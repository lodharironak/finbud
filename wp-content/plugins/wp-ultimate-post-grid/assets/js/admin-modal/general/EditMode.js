import React, { Component, Fragment } from 'react';

import '../../../css/admin/modal/general/edit-mode.scss';

export default class EditMode extends Component {
    constructor(props) {
        super(props);

        this.state = {
            mode: Object.keys( this.props.modes )[0],
        }
    }

    render() {
        if ( ! this.props.modes ) {
            return null;
        }

        let selectedMode = this.props.modes.hasOwnProperty( this.state.mode ) ? this.props.modes[ this.state.mode ] : false;

        return (
            <Fragment>
                <div className="wpupg-admin-modal-field-edit-mode-container">
                    {
                        Object.keys( this.props.modes ).map((id, index) => {
                            const mode = this.props.modes[id];
        
                            return (
                                <a
                                    href="#"
                                    className={ `wpupg-admin-modal-field-edit-mode${ id === this.state.mode ? ' wpupg-admin-modal-field-edit-mode-selected' : '' }` }
                                    onClick={(e) => {
                                        e.preventDefault();
                                        this.setState({
                                            mode: id,
                                        });
                                    }}
                                    key={index}
                                >
                                    { mode.label }
                                </a>
                            )
                        })
                    }
                </div>
                <div className="wpupg-admin-modal-field-edit-mode-content">
                    { selectedMode.block }
                </div>
            </Fragment>
        );
    }
}