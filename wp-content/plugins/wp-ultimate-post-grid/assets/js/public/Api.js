const endpoint = wpupg_public.api_endpoint;

export default {
    loadItems( body ) {
        let loadEndpoint = endpoint;

        // WP Extended Search compatibility for text search filter.
        if ( body.hasOwnProperty( 'args' ) && body.args.hasOwnProperty( 'wpes' ) && 0 < body.args.wpes ) {
            loadEndpoint += `?wpessid=${ body.args.wpes }`;
        }

        const args = {
            method: 'POST',
            headers: {
                'X-WP-Nonce': wpupg_public.api_nonce,
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                // Don't cache API calls.
                'Cache-Control': 'no-cache, no-store, must-revalidate',
                'Pragma': 'no-cache',
                'Expires': 0,
            },
            credentials: 'same-origin',
            body: JSON.stringify( body ),
        };

        return fetch( loadEndpoint, args ).then( function ( response ) {
            if ( response.ok ) {
                return response.json();
            } else {
                // Log errors in console and try to get as much debug information as possible.
                console.log(loadEndpoint, args);
                console.log(response);

                try {
                    response.text().then(text => {
                        console.log(text);
                    })
                } catch(e) {
                    console.log(e);
                }

                return false;
            }
        } );
    },
};
