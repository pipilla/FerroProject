import React from 'react';
import { Excalidraw } from '@excalidraw/excalidraw';
import '@excalidraw/excalidraw/index.css';

const ExcalidrawComponent = () => {
    return (
        <>
            <h1 style={{ textAlign: "center" }}>Excalidraw Example</h1>
            <div style={{ height: "500px" }}>
                <Excalidraw />
            </div>
        </>
    );
};

export default ExcalidrawComponent;
