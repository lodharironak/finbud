import React, { Component, Fragment } from 'react';

import '../../../css/admin/modal/grid.scss';

import Api from 'Shared/Api';
import Loader from 'Shared/Loader';
import { __wpupg } from 'Shared/Translations';

import Edit from './Edit';
import Preview from './Preview';
import Header from '../general/Header';
import Footer from '../general/Footer';

export default class Grid extends Component {
    constructor(props) {
        super(props);

        const mode = props.hasOwnProperty( 'mode' ) ? props.mode : 'create';

        // Get grid fields.
        let grid = JSON.parse( JSON.stringify( wpupg_admin_manage_modal.grid ) );
        let loadingGrid = false;
        let versionWarning = false;

        if ( 'edit' === mode && ( props.args.hasOwnProperty( 'grid' ) || props.args.hasOwnProperty( 'gridId' ) ) ) {
            if ( props.args.hasOwnProperty( 'grid' ) ) {
                grid = JSON.parse( JSON.stringify( props.args.grid ) );
                versionWarning = this.checkGridVersionWarning( grid );
            } else {
                loadingGrid = true;
                Api.grid.get(props.args.gridId).then((data) => {
                    if ( data ) {
                        const grid = JSON.parse( JSON.stringify( data.grid ) );
                        this.setState({
                            grid,
                            originalGrid: JSON.parse( JSON.stringify( grid ) ),
                            loadingGrid: false,
                            versionWarning: this.checkGridVersionWarning( grid ),
                        });
                    }
                });
            }
        }

        // Set default field values.
        if ( 'create' === mode && props.args.hasOwnProperty( 'grid' ) ) {
            grid = {
                ...grid,
                ...props.args.grid,
            }

            if ( props.args.cloneGrid ) {
                delete grid.id;
            }
        }

        // Set initial state.
        this.state = {
            grid,
            mode,
            originalGrid: JSON.parse( JSON.stringify( grid ) ),
            saveCallback: props.args.hasOwnProperty( 'saveCallback' ) ? props.args.saveCallback : false,
            savingChanges: false,
            loadingGrid,
            versionWarning,
        };

        // Bind functions.
        this.onGridChange = this.onGridChange.bind(this);
        this.resetGrid = this.resetGrid.bind(this);
        this.saveGrid = this.saveGrid.bind(this);
        this.allowCloseModal = this.allowCloseModal.bind(this);
    }

    checkGridVersionWarning( grid ) {
        return '0.0.0' === grid.version;
    }

    onGridChange(fields) {
        this.setState((prevState) => ({
            grid: {
                ...JSON.parse( JSON.stringify( prevState.grid ) ),
                ...JSON.parse( JSON.stringify( fields ) ),
            }
        }));
    }

    resetGrid() {
        if ( this.changesMade() ) {
            this.setState({
                grid: JSON.parse( JSON.stringify( this.state.originalGrid ) ),
            });
        }
    }

    saveGrid( closeModal ) {
        if ( this.changesMade() ) {
            this.setState({
                savingChanges: true,
            }, () => {
                const asNewGrid = 'edit' === this.state.mode ? false : true;
                Api.grid.save(asNewGrid, this.state.grid).then((data) => {
                    let newState = {
                        savingChanges: false,
                    }

                    if ( data ) {
                        newState.grid = JSON.parse( JSON.stringify( data.grid ) );
                        newState.originalGrid = JSON.parse( JSON.stringify( data.grid ) );
                        newState.mode = 'edit';
                    }

                    this.setState(newState, () => {
                        if ( 'function' === typeof this.state.saveCallback ) {
                            this.state.saveCallback(this.state.grid);
                        }
                        
                        if ( closeModal ) {
                            this.props.maybeCloseModal();
                        }
                    });
                });
            });
        }
    }

    allowCloseModal() {
        return ! this.state.savingChanges && ( ! this.changesMade() || confirm( __wpupg( 'Are you sure you want to close without saving changes?' ) ) );
    }

    changesMade() {
        return JSON.stringify( this.state.grid ) !== JSON.stringify( this.state.originalGrid );
    }

    render() {
        return (
            <Fragment>
                <Header
                    onCloseModal={ this.props.maybeCloseModal }
                >
                    {
                        'edit' === this.state.mode
                        ?
                        `${ __wpupg( 'Edit Grid' ) }${ this.state.loadingGrid ? '' : ` #${this.state.grid.id}${ this.state.grid.name ? ` - ${this.state.grid.name}` : `` }` }`
                        :
                        __wpupg( 'Create new Grid' )
                    }
                </Header>
                <div className="wpupg-admin-modal-content">
                    {
                        this.state.loadingGrid
                        ?
                        <Loader/>
                        :
                        <Fragment>
                            {
                                this.state.versionWarning
                                ?
                                <Fragment>
                                    <p>
                                        This grid was created before WP Ultimate Post Grid 3.0.0, which was a major update.
                                    </p>
                                    <p>
                                        Editing the grid now will break any backwards compatibility, so make sure you are ready to move to version 3.0.0 before editing.
                                    </p>
                                    <p>
                                        <a href="https://help.bootstrapped.ventures/article/217-wp-ultimate-post-grid-legacy" target="_blank">Learn More</a>
                                    </p>
                                </Fragment>
                                :
                                <Fragment>
                                    <Edit
                                        grid={ this.state.grid }
                                        onGridChange={ this.onGridChange }
                                    />
                                    <Preview
                                        grid={ this.state.grid }
                                    />
                                </Fragment>
                            }
                        </Fragment>
                    }
                </div>
                <Footer
                    savingChanges={ this.state.savingChanges }
                >
                    {
                        this.state.versionWarning
                        ?
                        <Fragment>
                            <button
                                className="button"
                                onClick={ this.props.maybeCloseModal }
                            >
                                { __wpupg( 'Close' ) }
                            </button>
                            <button
                                className="button button-primary"
                                onClick={ () => {
                                    this.setState({
                                        versionWarning: false,
                                    }, () => {
                                        this.onGridChange({ version: '3.0.0' } ); // Allows saving to prevent warning next time.
                                    } );
                                } }
                            >
                                { __wpupg( 'I Understand and want to edit the grid' ) }
                            </button>
                        </Fragment>
                        :
                        <Fragment>
                            <button
                                className="button"
                                onClick={ this.resetGrid }
                                disabled={ ! this.changesMade() }
                            >
                                { __wpupg( 'Cancel Changes' ) }
                            </button>
                            <button
                                className="button button-primary"
                                onClick={ () => this.saveGrid( false ) }
                                disabled={ ! this.changesMade() }
                            >
                                { 'edit' === this.state.mode ? __wpupg( 'Save Changes' ) : __wpupg( 'Create Grid' ) }
                            </button>
                            <button
                                className="button button-primary"
                                onClick={ () => this.saveGrid( true ) }
                                disabled={ ! this.changesMade() }
                            >
                                { 'edit' === this.state.mode ? __wpupg( 'Save & Close' ) : __wpupg( 'Create & Close' ) }
                            </button>
                        </Fragment>
                    }
                </Footer>
            </Fragment>
        );
    }
}