import React, { Component, Fragment } from 'react';

import Api from 'Shared/Api';
import Loader from 'Shared/Loader';
import { __wpupg } from 'Shared/Translations';

export default class Preview extends Component {
    constructor(props) {
        super(props);

        // Set initial state.
        this.state = {
            loading: false,
            needsRefresh: false,
            html: false,
            hasError: false,
            device: 'desktop',
        };
    }

    componentDidCatch() {
        this.setState({
            hasError: true,
        });
    }

    componentDidMount() {
        this.previewGrid();
    }

    componentDidUpdate(prevProps) {
        let newGrid = JSON.parse( JSON.stringify( this.props.grid ) );
        let oldGrid = JSON.parse( JSON.stringify( prevProps.grid ) );

        // Ignore grid fields.
        const ignoreGridFields = [ 'name', 'slug', 'metadata', 'metadata_name', 'metadata_description' ];
        for ( let ignoreField of ignoreGridFields ) {
            delete newGrid[ ignoreField ];
            delete oldGrid[ ignoreField ];
        }

        // Ignore filter fields
        const ignoreFilterFields = [ 'id' ];
        for ( let i = 0; i < newGrid.filters.length; i ++ ) {
            for ( let ignoreField of ignoreFilterFields ) {
                delete newGrid.filters[ i ][ ignoreField ];

                if ( oldGrid.filters.length > i ) {
                    delete oldGrid.filters[ i ][ ignoreField ];
                }
            }
        }

        if ( JSON.stringify( newGrid ) !== JSON.stringify( oldGrid ) ) {
            this.previewGrid();
        }
    }

    previewGrid() {
        if ( this.state.loading ) {
            if ( ! this.state.needsRefresh ) {
                this.setState({
                    needsRefresh: true,
                });
            }
        } else {
            this.setState({
                loading: true,
            }, () => {
                let previewGrid = JSON.parse( JSON.stringify( this.props.grid ) );
                previewGrid.slug = 'preview';
                
                Api.preview.grid( previewGrid ).then((data) => {
                    this.setState({
                        html: data.html,
                        loading: false,
                        hasError: false,
                    }, () => {
                        WPUPG_Grid.init( 'wpupg-grid-preview', data.args );

                        // Need to refresh again.
                        if ( this.state.needsRefresh ) {
                            this.setState({
                                needsRefresh: false,
                            }, () => this.previewGrid() );
                        }
                    });
                });
            });
        }
    }

    checkPremium() {
        if ( ! wpupg_admin.addons.premium ) {
            const { grid } = this.props;

            // Data Source.
            if ( 'posts' !== grid.type ) { return true; }
            if ( 'custom' === grid.order_by ) { return true; }

            // Pagination.
            if ( ! [ 'none', 'pages' ].includes( grid.pagination_type ) ) { return true; }

            // Filters.
            if ( grid.filters_enabled ) {
                for ( let i = 0; i < grid.filters.length; i++ ) {
                    const filter = grid.filters[ i ];

                    if ( 'isotope' !== filter.type ) { return true; }
                    if ( filter.options.count ) { return true; }
                    if ( filter.options.multiselect ) { return true; }
                }
            }
        }

        return false;
    }

    render() {
        const devices = [
            {
                value: 'desktop',
                label: __wpupg( 'Desktop Preview' ),
            },
            {
                value: 'tablet',
                label: __wpupg( 'Tablet Preview' ),
            },
            {
                value: 'mobile',
                label: __wpupg( 'Mobile Preview' ),
            },
        ];

        return (
            <div className="wpupg-admin-modal-grid-preview-container">
                <div className="wpupg-admin-modal-fields-group-header wpupg-admin-modal-grid-preview-header">
                    {
                        devices.map((device, index) => (
                            <span
                                onClick={ () => {
                                    this.setState({
                                        device: device.value,
                                    }, () => {
                                        WPUPG_Grids[ 'wpupg-grid-preview' ].layout();
                                    });
                                }}
                                data-device={ device.value }
                                className={ `wpupg-admin-modal-grid-preview-device${device.value === this.state.device ? ' active' : ''}` }
                                key={ index }
                            >{ device.label }</span>
                        ))
                    }
                </div>
                {
                    this.checkPremium()
                    ?
                    <p style={ { color: 'darkred' } }>
                        { __wpupg( "You've selected features that are only available in" ) } <a href="https://bootstrapped.ventures/wp-ultimate-post-grid/get-the-plugin/">WP Ultimate Post Grid Premium</a>.
                    </p>
                    :
                    <Fragment>
                        {
                            this.state.loading || this.state.hasError || false === this.state.html
                            ?
                            <Loader />
                            :
                            <div
                                className={ `wpupg-admin-modal-grid-preview wpupg-admin-modal-grid-preview-${ this.state.device }` }
                                dangerouslySetInnerHTML={ { __html: this.state.html } }
                            />
                        }
                    </Fragment>
                }
            </div>
        );
    }
}