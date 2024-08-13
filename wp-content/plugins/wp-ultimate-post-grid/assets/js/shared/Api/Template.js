import ApiWrapper from 'Shared/ApiWrapper';

const templateEndpoint = wpupg_admin.endpoints.template;
const debounceTime = 500;

let previewPromises = [];
let previewRequests = {};
let previewRequestsTimer = null;

export default {
    previewShortcode(uid, shortcode, item) {
        previewRequests[uid] = shortcode;

        clearTimeout(previewRequestsTimer);
        previewRequestsTimer = setTimeout(() => {
            this.previewShortcodes( item );
        }, debounceTime);

        return new Promise( r => previewPromises.push( r ) );
    },
    previewShortcodes( item ) {
        const thesePromises = previewPromises;
        const theseRequests = previewRequests;
        previewPromises = [];
        previewRequests = {};

        const data = {
            shortcodes: theseRequests,
            item,
        };

        fetch(`${templateEndpoint}/preview`, {
            method: 'POST',
            headers: {
                'X-WP-Nonce': wpupg_admin.api_nonce,
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            credentials: 'same-origin',
            body: JSON.stringify(data),
        }).then(response => {
            return response.json().then(json => {
                let result = response.ok ? json.preview : {};

                thesePromises.forEach( r => r( result ) );
            });
        });
    },
    save(template) {
        const data = {
            template,
        };

        return ApiWrapper.call( templateEndpoint, 'POST', data );
    },
    delete(slug) {
        const data = {
            slug,
        };

        return ApiWrapper.call( templateEndpoint, 'DELETE', data );
    },
    searchItems( input ) {
        const data = {
            input,
        };

        return ApiWrapper.call( `${templateEndpoint}/preview-item`, 'POST', data );
    },
};
