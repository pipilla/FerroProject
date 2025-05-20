import React, { useRef } from 'react';
import { Excalidraw } from '@excalidraw/excalidraw';
import '@excalidraw/excalidraw/index.css';

const ExcalidrawComponent = () => {
    const excalidrawWrapperRef = useRef(null);

    const handleFullscreen = () => {
        const el = excalidrawWrapperRef.current;
        if (el.requestFullscreen) {
            el.requestFullscreen();
        } else if (el.webkitRequestFullscreen) {
            el.webkitRequestFullscreen(); // Safari
        } else if (el.msRequestFullscreen) {
            el.msRequestFullscreen(); // IE11
        }
    };

    return (
        <>
            <div
                ref={excalidrawWrapperRef}
                style={{ height: "66vh", width: "100%" }}
                className="m-5"
            >
                <Excalidraw />
            </div>
            <button
                onClick={handleFullscreen}
                className="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200 shadow-md mx-auto my-2"
            >
                <i className="fas fa-expand mr-2"></i>Pantalla completa
            </button>
        </>
    );
};

export default ExcalidrawComponent;
