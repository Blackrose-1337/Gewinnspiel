import ky, { type Options } from "ky";
import { formatISO } from "date-fns";
import _ from "lodash";
import { Cookies } from "quasar";

const token = Cookies.get("PHPSESSID") ?? null;
export default class NetworkHelper {
    private API =
        import.meta.env.MODE === "production" ? "index.php/api/" : `http://${window.location.host.split(":")[0]}:8000/src/index.php/`;

    private getOptionsAndUrl(url: string, queryParams: any | null) {
        const options = {

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
        const method = 'GET';
        const res = await this.request(fullUrl,method);

     
        if (res.status === 200) {
            return res.json();
        } else {
            console.error("" + res.status + " " + res.statusText);
            return res.json();
        }
    }
    

    async post<T>(url: string, data: object | null = null): Promise<T | null> {
        const method = 'POST'
        const { fullUrl } = this.getOptionsAndUrl(url, null);
        

        const res = await this.request(fullUrl,method , JSON.stringify(data));


        if (res.status === 200) {
            return res.json();
        } else {
            console.error("" + res.status + " " + res.statusText);
            return res.json();
        }
    }

    async request<T>(url: string, method: string, data?: string) {
        let endData = await fetch(url, {
            method: method, // *GET, POST, PUT, DELETE, etc.
            cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
            credentials: 'include',
            headers: {
                'Cookie': document.cookie,
            },
            redirect: 'follow', // manual, *follow, error
            referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
            body: data
        }).then((response) => {
            return response;
        });


        return endData;
    }
    async requestGet<T>(url: string, data: string) {
        let endData = await fetch(url, {
            method: 'GET', // *GET, POST, PUT, DELETE, etc.
            cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
            headers: {
                'Cookie': document.cookie,
                'Content-Type': 'json',
            },
            redirect: 'follow', // manual, *follow, error
            referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
            body: data
        }).then((response) => {
            return response;
        });


        return endData;
    }


    // private static getCookie(name: string) {
    //     let cookieValue: string | null = null;
    //     if (document.cookie && document.cookie !== "") {
    //         const cookies = document.cookie.split(";");
    //         for (let i = 0; i < cookies.length; i++) { 
    //             const cookie = cookies[i].trim();
    //             // Does this cookie string begin with the name we want?
    //             if (cookie.substring(0, name.length + 1) === name + "=") {
    //                 cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
    //                 break;
    //             }
    //         }
    //     }
    //     return cookieValue;
    // }
}
