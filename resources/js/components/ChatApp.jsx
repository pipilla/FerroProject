import React, { useState, useEffect } from 'react';
import ChatList from './ChatList';
import ChatRoom from './ChatRoom';

const ChatApp = () => {
    const [user, setUser] = useState(null);
    const [chats, setChats] = useState([]);
    const [selectedChat, setSelectedChat] = useState(null);

    useEffect(() => {
        // Verifica usuario logueado
        fetch('/api/user')
            .then(res => {
                if (!res.ok) throw new Error('Error al obtener el usuario');
                return res.json();
            })
            .then(data => {
                setUser(data);
            })
            .catch(err => {
                console.error('error:', err);
                setUser(false);
            });

        // Cargar lista de chats
        fetch('/api/chatList')
            .then(res => res.json())
            .then(data => setChats(data));
    }, []);

    if (user === null) return <div>Cargando...</div>;
    if (user === false) return <div>Acceso denegado</div>;

    return (
        <div className="flex gap-4 p-4">
            <ChatList chats={chats} onSelectChat={setSelectedChat} />
            {selectedChat && (
                <ChatRoom chat={selectedChat} currentUser={user} />
            )}
        </div>
    );
};

export default ChatApp;
