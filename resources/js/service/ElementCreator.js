import React from 'react';
import ReactDOM from 'react-dom';

export function ElementLoading(element) {    
    var input = document.createElement('span');
    input.setAttribute('class', element.class);
    ReactDOM.render( "", input );
    return input;
}
