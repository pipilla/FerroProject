import React, { useState, useEffect } from 'react';

const ChatList = ({ chats, onSelectChat }) => {
    const [showUserList, setShowUserList] = useState(false);
    const [users, setUsers] = useState([]);

    const fetchUsers = () => {
        fetch('/api/users', {
            headers: { 'Accept': 'application/json' }
        })
            .then(res => res.json())
            .then(setUsers)
            .catch(err => console.error('Error al cargar usuarios:', err));
    };

    const createChat = (userId) => {
        fetch('/api/chats', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ user_id: userId }),
        })
            .then(res => res.json())
            .then(newChat => {
                onSelectChat(newChat); // Entrar al nuevo chat
                setShowUserList(false);
            })
            .catch(err => console.error('Error al crear chat:', err));
    };

    const openUserList = () => {
        setShowUserList(true);
        fetchUsers();
    };

    return (
        <div className="w-1/3 border-r p-2">
            <div className="flex justify-between items-center mb-2">
                <h2 className="text-lg font-bold">Tus chats</h2>
                <button
                    className="bg-blue-500 text-white px-2 py-1 rounded text-sm"
                    onClick={openUserList}
                >
                    Nuevo chat
                </button>
            </div>

            <ul>
                {(chats != undefined) ? chats.map(chat => (
                    <li
                        key={chat.id}
                        onClick={() => onSelectChat(chat)}
                        className="cursor-pointer hover:bg-gray-100 p-2 rounded"
                    >
                        {chat.is_group ? chat.name : 'Chat privado #' + chat.id}
                    </li>
                )) : <p>No hay ningún chat disponible.</p>}
            </ul>

            {showUserList && (
                <div className="mt-4 border-t pt-2">
                    <h3 className="text-sm font-bold mb-1">Selecciona un usuario:</h3>
                    <ul className="max-h-48 overflow-y-auto">
                        {users.map(user => (
                            <li
                                key={user.id}
                                onClick={() => createChat(user.id)}
                                className="cursor-pointer hover:bg-gray-200 p-2 rounded"
                            >
                                {user.name}
                            </li>
                        ))}
                    </ul>
                </div>
            )}
        </div>
    );
};

export default ChatList;
