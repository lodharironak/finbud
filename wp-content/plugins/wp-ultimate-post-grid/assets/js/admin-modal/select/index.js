import React, { Component, Fragment } from 'react';

import '../../../css/admin/modal/select.scss';

import { __wpupg } from 'Shared/Translations';
import Header from '../general/Header';
import Footer from '../general/Footer';

import SelectFilter from './SelectFilter';
import SelectGrid from './SelectGrid';

export default class Select extends Component {
    constructor(props) {
        super(props);
    
        this.state = {
            grid: false,
            filter: false,
        };
    }

    selectionsMade() {
        return ( ! this.props.args.fields.grid || false !== this.state.grid )
                && ( ! this.props.args.fields.filter || false !== this.state.filter );
    }

    render() {
        return (
            <Fragment>
                <Header
                    onCloseModal={ this.props.maybeCloseModal }
                >
                    {
                        this.props.args.title
                        ?
                        this.props.args.title
                        :
                        'WP Ultimate Post Grid'
                    }
                </Header>
                <div className="wpupg-admin-modal-select-container">
                    {
                        this.props.args.fields.grid
                        ?
                        <SelectGrid
                            placeholder={ __wpupg( 'Select Grid' ) }
                            value={ this.state.grid }
                            onChange={(grid) => {
                                this.setState({
                                    grid,
                                    filter: false,
                                });
                            }}
                        />
                        :
                        null
                    }
                    {
                        this.props.args.fields.filter
                        ?
                        <Fragment>
                            <br/>
                            <SelectFilter
                                placeholder={ __wpupg( 'Select Filter' ) }
                                grid={ this.state.grid }
                                value={ this.state.filter }
                                onChange={(filter) => {
                                    this.setState({ filter });
                                }}
                            />
                        </Fragment>
                        :
                        null
                    }
                </div>
                <Footer
                    savingChanges={ false }
                >
                    <button
                        className="button button-primary"
                        onClick={ () => {
                            if ( 'function' === typeof this.props.args.nextStepCallback ) {
                                this.props.args.nextStepCallback( this.state );
                            } else {
                                if ( 'function' === typeof this.props.args.insertCallback ) {
                                    this.props.args.insertCallback( this.state );
                                }
                                this.props.maybeCloseModal();
                            }
                        } }
                        disabled={ ! this.selectionsMade() }
                    >
                        {
                            this.props.args.button
                            ?
                            this.props.args.button
                            :
                            __wpupg( 'Select' )
                        }
                    </button>
                </Footer>
            </Fragment>
        );
    }
}