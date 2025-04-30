import React, { useState, useEffect } from 'react';

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
        </div>
    );
};

export default ChatApp;
