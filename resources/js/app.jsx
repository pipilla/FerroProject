import './bootstrap.js';
import React from 'react';
import { createRoot } from 'react-dom/client';
import ChatApp from './components/ChatApp.jsx';

const el = document.getElementById('chat-root');

if (el) {
    const root = createRoot(el);
    root.render(<ChatApp/>);
}
