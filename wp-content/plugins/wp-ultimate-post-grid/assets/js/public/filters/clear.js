window.WPUPG_Filter_clear = {
    init: ( gridElemId, args ) => {
        const id = `${ gridElemId }-filter-${ args.id }`;
        const elem = document.querySelector( '#' + id );

        if ( ! elem ) {
            return false;
        }

        let filter = {
            gridElemId,
            args,
            id,
            elem,
            selected: {},
            getSelectors() { return false; },
            getQueryArgs() { return false; },
            buttonClear: false,
            onClickButtonClear() {
                if ( '' !== WPUPG_Grids[ this.gridElemId ].getFilterString( true ) ) {
                    WPUPG_Grids[ this.gridElemId ].clearAll();
                }
            },
            init() {
                const button = this.elem.querySelector( '.wpupg-filter-clear-button' );

                if ( button ) {
                    filter.buttonClear = button;

                    button.addEventListener( 'click', (e) => {
                        if ( e.which === 1 ) { // Left mouse click.
                            filter.onClickButtonClear();
                            button.blur();
                        }
                    } );
                    button.addEventListener( 'keydown', (e) => {
                        if ( e.which === 13 || e.which === 32 ) { // Space or ENTER.
                            filter.onClickButtonClear();
                        }
                    } );
                }

                WPUPG_Grids[ this.gridElemId ].on( 'filter', () => {
                    if ( '' === WPUPG_Grids[ this.gridElemId ].getFilterString( true ) ) {
                        this.buttonClear.style.opacity = '';
                    } else {
                        this.buttonClear.style.opacity = '1';
                    }
                } );
            },
        }

        return filter;
    },
}