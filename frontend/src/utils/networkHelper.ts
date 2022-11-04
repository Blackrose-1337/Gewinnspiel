import ky from "ky";
import { formatISO } from "date-fns";

export default class NetworkHelper {
    private API =
        import.meta.env.MODE === "production" ? "/api/" : `http://${window.location.host.split(":")[0]}:8080/`;

    private getOptionsAndUrl(url: string, queryParams: any | null) {
        const options = {
            timeout: 30000,
            credentials: import.meta.env.MODE === "production" ? "same-origin" : "include",
        };
        let fullUrl = this.API + url.replace(/\/\/$/, "/") + "/?";
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

    async post<T>(url: string, data: object | null = null, expectResponse = true): Promise<T> {
        const { options, fullUrl } = this.getOptionsAndUrl(url, null);
        if (data instanceof FormData) {
            options.body = data;
        } else if (data) {
            options.json = data;
        }
        const res = await ky.post(fullUrl, options);
        return res;
    }
}
