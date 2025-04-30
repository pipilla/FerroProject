import React, { useState, useEffect } from 'react';
<<<<<<< HEAD
import ChatList from './ChatList';
import ChatRoom from './ChatRoom';

const ChatApp = () => {
    const [user, setUser] = useState(null);
    const [chats, setChats] = useState(undefined);
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
=======

const ChatApp = () => {
    const [messages, setMessages] = useState([]);
    const [newMessage, setNewMessage] = useState('');

    console.log("React está funcionando");

    useEffect(() => {
        fetch('/api/messages')
            .then(res => res.json())
            .then(data => setMessages(data));
    }, []);

    const sendMessage = async () => {
        await fetch('/api/messages', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({ content: newMessage }),
        });

        setNewMessage('');
        // Simple recarga de mensajes, reemplazable con WebSockets
        const res = await fetch('/api/messages');
        setMessages(await res.json());
    };

    return (
        <div className="p-4 border rounded max-w-lg mx-auto">
            <h2 className="text-xl mb-4">Chat</h2>
            <div className="h-64 overflow-y-auto border p-2 mb-2">
                {messages.map(msg => (
                    <div key={msg.id}>{msg.content}</div>
                ))}
            </div>
            <input
                type="text"
                value={newMessage}
                onChange={e => setNewMessage(e.target.value)}
                className="border p-1 w-full mb-2"
            />
            <button onClick={sendMessage} className="bg-blue-500 text-white px-4 py-2 rounded">
                Enviar
            </button>
>>>>>>> f2aff96 (Cambios para que funcione react)
        </div>
    );
};

export default ChatApp;
