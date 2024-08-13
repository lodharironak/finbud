import React from 'react';

import CodeMirror from 'react-codemirror';
require('codemirror/lib/codemirror.css');
require('codemirror/mode/xml/xml');

const HTML = (props) => {
    return (
        <div className="wpupg-main-container">
            <h2 className="wpupg-main-container-name">HTML</h2>
            <p>
                Learn more about specific classes you can use to <a href="https://help.bootstrapped.ventures/article/255-classes-you-can-use-in-the-grid-template-editor" target="_blank">align elements or show on hover</a>. You can also make use of <a href="https://help.bootstrapped.ventures/article/254-using-conditions-in-the-grid-template" target="_blank">condition shortcodes</a> to show/hide certain parts of the template based on the grid item's taxonomy or custom field.
            </p>
            <CodeMirror
                className="wpupg-main-container-html"
                value={props.template.html}
                onChange={(value) => props.onChangeValue(value)}
                options={{
                    lineNumbers: true,
                    mode: 'xml',
                    htmlMode: true,
                }}
            />
        </div>
    );
}

export default HTML;