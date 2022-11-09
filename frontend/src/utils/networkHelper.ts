import ky, { type Options } from "ky";
import { formatISO } from "date-fns";
// import { json } from "stream/consumers";

export default class NetworkHelper {
    private API =
        import.meta.env.MODE === "production" ? "/api/" : `http://${window.location.host.split(":")[0]}:8000/`;

    private getOptionsAndUrl(url: string, queryParams: any | null) {
        const options = {
            // timeout: 30000,
            // credentials: import.meta.env.MODE === "production" ? "same-origin" : "include",
        } as Options;
        let fullUrl = this.API + url.replace(/\/\/$/, "/") + "/?format=json&";
        const ignoreCache = false;
        if (ignoreCache) {
            if (!queryParams) {
                queryParams = {};
            }
            queryParams["ts"] = formatISO(Date.now());
        }

        if (queryParams) {
            const mapped = Object.keys(queryParams)
                .filter(k => {
                    const v = queryParams[k];
                    return (v != null && !Array.isArray(v)) || (Array.isArray(v) && v?.length > 0);
                })
                .map(k => `${encodeURIComponent(k)}=${encodeURI(queryParams[k])}`);
            fullUrl += mapped.join("&");
            const withValues = _.pickBy(
                queryParams,
                v => (!_.isArray(v) && !_.isNil(v)) || (_.isArray(v) && _.size(v) > 0)
            );
            const queryString = _.map(withValues, (v, k) => `${encodeURIComponent(k)}=${encodeURI(v)}`);
            fullUrl += _.join(queryString, "&");
        }

        return { options, fullUrl: fullUrl };
    }

    async get<T>(url: string, queryParams: object | null = null): Promise<T> {
        const { options, fullUrl } = this.getOptionsAndUrl(url, queryParams);
        return (await ky.get(fullUrl, options)).json();
    }


    async post<T>(url: string, data: object | null = null): Promise<T | null> {
        const { fullUrl } = this.getOptionsAndUrl(url, null);
        const options = {
            method: "post",
            body: JSON.stringify(data)
        } as Options
    
        
        // const csrfToken = NetworkHelper.getCookie("csrftoken");
        // if (csrfToken) {
        //     options.headers = {
        //         "X-CSRFToken": csrfToken,
        //     };
        // }
        const res = await ky.post(fullUrl,options);
        if (res.status !== 204) {
            return res.json();
        } else {
            return null;
        }
    }
}
