import React, { useState, useEffect } from 'react';

const ChatRoom = ({ chat, currentUser }) => {
    const [messages, setMessages] = useState([]);
    const [newMessage, setNewMessage] = useState('');

    useEffect(() => {
        fetch(`/api/messages/${chat.id}`)
            .then(res => res.json())
            .then(data => setMessages(data));
    }, [chat]);

    const sendMessage = async () => {
        const res = await fetch('/api/messages', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({
                chat_id: chat.id,
                content: newMessage,
            }),
        });

        const newMsg = await res.json();
        setMessages(prev => [...prev, newMsg]);
        setNewMessage('');
    };

    return (
        <div className="w-2/3 p-4 border rounded">
            <h2 className="text-xl mb-4">
                {chat.is_group ? chat.name : 'Chat privado'}
            </h2>
            <div className="h-64 overflow-y-auto border p-2 mb-2">
                {messages.map(msg => (
                    <div key={msg.id} className="mb-1">
                        <strong>{msg.sender.name}:</strong> {msg.content}
                    </div>
                ))}
            </div>
            <input
                type="text"
                value={newMessage}
                onChange={e => setNewMessage(e.target.value)}
                className="border p-1 w-full mb-2"
            />
            <button
                onClick={sendMessage}
                className="bg-blue-500 text-white px-4 py-2 rounded"
            >
                Enviar
            </button>
        </div>
    );
};

export default ChatRoom;
