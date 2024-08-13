import React, { Component } from 'react';

import reactCSS from 'reactcss';
import { SketchPicker } from 'react-color';
 
export default class FieldColor extends Component {
    constructor(props) {
        super(props);

        this.state = {
            displayColorPicker: false,
        }
    }

    handleClick() {
        this.setState({ displayColorPicker: !this.state.displayColorPicker })
    };
    
    handleClose() {
        this.setState({ displayColorPicker: false })
    };
    
    handleChange(color) {
        this.props.onChange(color.hex);
    };

    render() {
        const styles = reactCSS({
            'default': {
                color: {
                    width: '36px',
                    height: '14px',
                    borderRadius: '2px',
                    background: `${ this.props.value }`,
                },
                swatch: {
                    padding: '5px',
                    background: '#fff',
                    borderRadius: '4px',
                    border: '1px solid #cccccc',
                    display: 'inline-block',
                    cursor: 'pointer',
                },
                popover: {
                    position: 'absolute',
                    zIndex: '2',
                },
                cover: {
                    position: 'fixed',
                    top: '0px',
                    right: '0px',
                    bottom: '0px',
                    left: '0px',
                },
            },
        });

        return (
            <div className="wpupg-admin-modal-field-color">
                <div style={ styles.swatch } onClick={ this.handleClick.bind(this) }>
                    <div style={ styles.color } />
                </div>
                {
                    this.state.displayColorPicker
                    ?
                    <div style={ styles.popover }>
                        <div style={ styles.cover } onClick={ this.handleClose.bind(this) }/>
                        <SketchPicker
                            color={ this.props.value }
                            onChange={ this.handleChange.bind(this) }
                            disableAlpha={ true }
                        />
                    </div>
                    :
                    null
                }
            </div>
        );
    }
}