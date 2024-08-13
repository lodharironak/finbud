export default ( elemId, args ) => {
    return {
        onHover( item, hovering ) {
            const containers = item.querySelectorAll('.wpupg-hover');

            for ( let container of containers ) {
                if ( hovering ) {
                    container.classList.add('wpupg-hovering');
                } else {
                    container.classList.remove('wpupg-hovering');
                }
            }
        },
        initHover() {
            const handler = this.onHover;

            this.elem.addEventListener( 'mouseover', function(e) {
                for ( let target = e.target; target && target != this; target = target.parentNode ) {
                    if ( target.matches( '.wpupg-item' ) ) {
                        handler( target, true );
                        break;
                    }
                }
            }, false );

            this.elem.addEventListener( 'mouseout', function(e) {
                for ( let target = e.target; target && target != this; target = target.parentNode ) {
                    if ( target.matches( '.wpupg-item' ) ) {
                        handler( target, false );
                        break;
                    }
                }
            }, false );
        },
    }
};