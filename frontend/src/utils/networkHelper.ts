import ky, { type Options } from "ky";
import { formatISO } from "date-fns";
import _ from "lodash";
import { Cookies } from "quasar";

Cookies.set("www.stickstoff.de-competition","asdEBKA23+test",{ expires: '12min'})
const token = Cookies.get("www.stickstoff.de-competition");
export default class NetworkHelper {
    private API =
        import.meta.env.MODE === "production" ? "/api/" : `http://${window.location.host.split(":")[0]}:8000/`;

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
        options.method = "get";
        options.headers = {
                Authorization: "Bearer " + token,
        }
        const response = await ky.get(fullUrl, options);

        /*const newtoken = await answer.headers.get('Authorization');
        await answer.headers.forEach(e => {
            console.log(e);
        });*/
        response.headers.forEach(e => {
            console.log(e);
        })
        // let newtoken = response.headers.get('Sec-Authorization');
    
        // console.log(newtoken);
        return response.json();
    }
    

    async post<T>(url: string, data: object | null = null): Promise<T | null> {
        const { fullUrl } = this.getOptionsAndUrl(url, null);
        const options = {
            method: "post",
            body: JSON.stringify(data),
            // headers: {
            //     Authorization: "Bearer " + token,
            // }
        } as Options


        const res = await ky.post(fullUrl, options);
        if (res.status !== 204) {
            return res.json();
        } else {
            return null;
        }
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
