import React from 'react';

const ChatList = ({ chats, onSelectChat }) => {
    return (
        <div className="w-1/3 border-r p-2">
            <h2 className="text-lg font-bold mb-2">Tus chats</h2>
            <ul>
                {chats.map(chat => (
                    <li
                        key={chat.id}
                        onClick={() => onSelectChat(chat)}
                        className="cursor-pointer hover:bg-gray-100 p-2 rounded"
                    >
                        {chat.is_group ? chat.name : 'Chat privado #' + chat.id}
                    </li>
                ))}
            </ul>
        </div>
    );
};

export default ChatList;
