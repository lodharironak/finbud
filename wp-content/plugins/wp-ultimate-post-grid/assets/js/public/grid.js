import Isotope from 'isotope-layout';
import imagesLoaded from 'imagesloaded';

import '../../css/public/filter.scss';
import '../../css/public/grid.scss';
import '../../css/public/pagination.scss';
import '../../css/public/responsive.scss';

import './filters/clear';
import './filters/isotope';
import './pagination/pages';

import gridCustomFields from './grid/custom-fields';
import gridDeeplinking from './grid/deeplinking';
import gridEmpty from './grid/empty';
import gridEvents from './grid/events';
import gridFilters from './grid/filters';
import gridHover from './grid/hover';
import gridLayout from './grid/layout';
import gridPagination from './grid/pagination';
import gridResponsive from './grid/responsive';
import gridSorting from './grid/sorting';

window.WPUPG_Grids = {};

window.WPUPG_Grid = {
    init: ( elemId, args = false ) => {
        const elem = document.querySelector( '#' + elemId );

        if ( elem ) {
            if ( wpupg_public.debugging ) { console.log( 'WPUPG Init', args ); }

            const gridId = elem.dataset.hasOwnProperty( 'gridId' ) ? elem.dataset.gridId : elemId.substr( 11 );
            const gridSlug = elemId.substr( 11 );

            // Remove loading class.
            elem.classList.remove( 'wpupg-grid-loading' );

            // Try to get args from localized data if not set.
            if ( false === args ) {
                if ( window.hasOwnProperty( `wpupg_grid_args_${ gridId }` ) ) {
                    args = window[ `wpupg_grid_args_${ gridId }` ];
                } else {
                    // No arguments found to init, return.
                    return;
                }
            }

            // Check if already exists.
            if ( WPUPG_Grids.hasOwnProperty( elemId ) ) {
                WPUPG_Grids[ elemId ].isotope.destroy();
                delete WPUPG_Grids[ elemId ];
            }

            WPUPG_Grids[ elemId ] = {
                args,
                elem,
                gridId,
                gridSlug,
                elemId,
                isPreview: args.hasOwnProperty( 'is_preview' ) ? args.is_preview : false,
                isotope: new Isotope( elem, args.isotope ),
                layout() {
                    this.isotope.layout();
                },
                // Moved to separate files for readability.
                ...gridCustomFields( elemId, args ),
                ...gridDeeplinking( elemId, args ),
                ...gridEmpty( elemId, args ),
                ...gridEvents( elemId, args ),
                ...gridFilters( elemId, args ),
                ...gridHover( elemId, args ),
                ...gridLayout( elemId, args ),
                ...gridPagination( elemId, args ),
                ...gridResponsive( elemId, args ),
                ...gridSorting( elemId, args ),
                init() {
                    // Init events first.
                    this.initEvents();

                    // Init rest.
                    this.initDeeplinking();
                    this.initEmpty();
                    this.initHover();
                    this.initLayout();
                    this.initPagination();
                    this.initResponsive();
                    this.initFilters();

                    // Fire init ready hook.
                    this.fireEvent( 'initReady' );

                    // Relayout after images have loaded.
                    imagesLoaded( this.elem, () => {
                        this.layout();
                    } );
                },
            };
            WPUPG_Grids[ elemId ].init();
        }
    },
};

// Init all grids we can find when the page is ready.
ready(() => {
    const grids = document.querySelectorAll( '.wpupg-grid' );

    for ( let grid of grids ) {
        WPUPG_Grid.init( grid.id );
    }
});

// Source: http://youmightnotneedjquery.com/#ready
function ready( fn ) {
    if (document.readyState != 'loading'){
        fn();
    } else {
        document.addEventListener('DOMContentLoaded', fn);
    }
}