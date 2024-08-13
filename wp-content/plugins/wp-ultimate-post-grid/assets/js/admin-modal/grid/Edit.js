import React, { Component } from 'react';

import { __wpupg } from 'Shared/Translations';
import Icon from 'Shared/Icon';

import SectionGeneral from './section/SectionGeneral';
import SectionDataSource from './section/SectionDataSource';
import SectionLimit from './section/SectionLimit';
import SectionFilter from './section/SectionFilter';
import SectionLayout from './section/SectionLayout';
import SectionItem from './section/SectionItem';
import SectionOther from './section/SectionOther';
import SectionPagination from './section/SectionPagination';

export default class Edit extends Component {
    constructor(props) {
        super(props);

        // Set initial state.
        this.state = {
            section: 'general',
        };
    }

    render() {
        let structure = [
            {
                id: 'general', name: __wpupg( 'General' ),
                help: 'https://help.bootstrapped.ventures/article/230-general',
                type: 'all',
                elem: (
                    <SectionGeneral
                        grid={ this.props.grid }
                        onGridChange={ this.props.onGridChange }
                    />
                )
            },
            {
                id: 'data-source', name: __wpupg( 'Data Source' ),
                help: 'https://help.bootstrapped.ventures/article/231-data-source',
                type: 'all',
                elem: (
                    <SectionDataSource
                        grid={ this.props.grid }
                        onGridChange={ this.props.onGridChange }
                    />
                )
            },
            {
                id: 'limit', name: __wpupg( 'Limit Items' ),
                help: 'https://help.bootstrapped.ventures/article/232-limit-items',
                type: 'all',
                elem: (
                    <SectionLimit
                        grid={ this.props.grid }
                        onGridChange={ this.props.onGridChange }
                    />
                )
            },
            {
                id: 'filters', name: __wpupg( 'Filters' ),
                help: 'https://help.bootstrapped.ventures/article/233-filters',
                type: 'posts',
                elem: (
                    <SectionFilter
                        grid={ this.props.grid }
                        onGridChange={ this.props.onGridChange }
                    />
                )
            },
            {
                id: 'layout', name: __wpupg( 'Layout' ),
                help: 'https://help.bootstrapped.ventures/article/234-layout',
                type: 'all',
                elem: (
                    <SectionLayout
                        grid={ this.props.grid }
                        onGridChange={ this.props.onGridChange }
                    />
                )
            },
            {
                id: 'item', name: __wpupg( 'Item' ),
                help: 'https://help.bootstrapped.ventures/article/235-item',
                type: 'all',
                elem: (
                    <SectionItem
                        grid={ this.props.grid }
                        onGridChange={ this.props.onGridChange }
                    />
                )
            },
            {
                id: 'pagination', name: __wpupg( 'Pagination' ),
                help: 'https://help.bootstrapped.ventures/article/236-pagination',
                type: 'posts',
                elem: (
                    <SectionPagination
                        grid={ this.props.grid }
                        onGridChange={ this.props.onGridChange }
                    />
                )
            },
            {
                id: 'other', name: __wpupg( 'Other' ),
                help: 'https://help.bootstrapped.ventures/article/237-other',
                type: 'all',
                elem: (
                    <SectionOther
                        grid={ this.props.grid }
                        onGridChange={ this.props.onGridChange }
                    />
                )
            },
        ];

        let selected = null;
    
        return (
            <div className="wpupg-admin-modal-grid-edit-container">
                <div className="wpupg-admin-modal-grid-edit-sections">
                    {
                        structure.map((group, index) => {
                            let className = null;

                            if ( group.id === this.state.section ) {
                                selected = group;
                                className = 'active';
                            }

                            if ( 'all' !== group.type && this.props.grid.type !== group.type ) {
                                return null;
                            }

                            return (
                                <a
                                    href="#"
                                    className={ className }
                                    onClick={ (e) => {
                                        e.preventDefault();
                                        this.setState({
                                            section: group.id,
                                        });
                                    }}
                                    key={ index }
                                >
                                    { group.name }
                                </a>
                            )
                        })
                    }
                </div>
                {
                    null !== selected
                    &&
                    <div className="wpupg-admin-modal-grid-edit">
                        <div className="wpupg-admin-modal-fields-group-header">{ selected.name }
                            {
                                selected.hasOwnProperty( 'help' )
                                &&
                                <Icon
                                    type="question"
                                    title={ __wpupg( 'Click to learn more about these options.' ) }
                                    className="wpupg-admin-icon-help"
                                    onClick={() => {
                                        window.open( selected.help, '_blank' );
                                    }}
                                />
                            }
                        </div>
                        {
                            selected.elem
                        }
                    </div>
                }
            </div>
        );
    }
}