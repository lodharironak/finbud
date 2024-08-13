import React, { Component, Fragment } from 'react';

import '../../../css/admin/modal/menu.scss';

import { __wpupg } from 'Shared/Translations';
import Header from '../general/Header';
import Button from 'Shared/Button';

export default class Menu extends Component {
    render() {
        return (
            <Fragment>
                <Header
                    onCloseModal={ this.props.maybeCloseModal }
                >
                    WP Ultimate Post Grid
                </Header>
                <div className="wpupg-admin-modal-menu-container">
                    <h2>{ __wpupg( 'Insert existing Grid' ) }</h2>
                    <div className="wpupg-admin-modal-menu-buttons">
                        <Button
                            isPrimary
                            onClick={ () => {
                                WPUPG_Modal.open( 'select', {
                                    title: __wpupg( 'Insert Grid with Filters' ),
                                    button: __wpupg( 'Insert' ),
                                    fields: {
                                        grid: true,
                                        filter: false,
                                    },
                                    insertCallback: ( fields ) => {
                                        if ( 'function' === typeof this.props.args.insertCallback ) {
                                            this.props.args.insertCallback( `[wpupg-grid-with-filters id="${ fields.grid }"]` );
                                        }
                                    },
                                }, true );
                            } }
                        >{ __wpupg( 'Insert Grid with Filters' ) }</Button>
                        <Button
                            onClick={ () => {
                                WPUPG_Modal.open( 'select', {
                                    title: __wpupg( 'Insert Grid only' ),
                                    button: __wpupg( 'Insert' ),
                                    fields: {
                                        grid: true,
                                        filter: false,
                                    },
                                    insertCallback: ( fields ) => {
                                        if ( 'function' === typeof this.props.args.insertCallback ) {
                                            this.props.args.insertCallback( `[wpupg-grid id="${ fields.grid }"]` );
                                        }
                                    },
                                }, true );
                            } }
                        >{ __wpupg( 'Insert Grid only' ) }</Button>
                        <Button
                            onClick={ () => {
                                WPUPG_Modal.open( 'select', {
                                    title: __wpupg( 'Insert Filter only' ),
                                    button: __wpupg( 'Insert' ),
                                    fields: {
                                        grid: true,
                                        filter: true,
                                    },
                                    insertCallback: ( fields ) => {
                                        if ( 'function' === typeof this.props.args.insertCallback ) {
                                            let shortcode = `[wpupg-filter id="${ fields.grid }"`;

                                            if ( true === fields.filter ) {
                                                shortcode += ']';
                                            } else {
                                                shortcode += ` filter="${ fields.filter }"]`;
                                            }

                                            this.props.args.insertCallback( shortcode );
                                        }
                                    },
                                }, true );
                            } }
                        >{ __wpupg( 'Insert Filter only' ) }</Button>
                    </div>
                </div>
            </Fragment>
        );
    }
}