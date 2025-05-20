
import React from 'react';
import ReactDOM from 'react-dom';
import ExcalidrawComponent from './components/ExcalidrawComponent.jsx';

if (document.getElementById('designer')) {
  ReactDOM.render(<ExcalidrawComponent />, document.getElementById('designer'));
}
