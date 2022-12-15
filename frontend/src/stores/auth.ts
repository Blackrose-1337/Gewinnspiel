import { defineStore } from "pinia";
import NetworkHelper from "@/utils/networkHelper";
import { Cookies, SessionStorage } from "quasar";



const api = new NetworkHelper();

export type State = {
    isAuthenticated: boolean;
    user: null | { username: string };
    isInitialized: boolean;
    role: string;
};

export const useAuthStore = defineStore({
    id: "auth",
    state: () =>
        ({
            isAuthenticated: false,
            user: null,
            isInitialized: false,
            role: '' as string,
        } as State),
    getters: {
        // isAuthenticated: state => state._isAuthenticated,
    },
    actions: {
        async login(email: string, password: string) {
            try {
                //test backend-valid
                // const res = await api.post<{ success: boolean; user: { email: string } }>("src/index.php/auth/login", {
                //     email: "poppel",
                //     password,
                //  });


                const res = await api.post<{ success: boolean; token: string; time: string }>("src/index.php/auth/login", {
                    email,
                    password,
                });

                if (res?.success) {
                    SessionStorage.set("www.stickstoff.de-competition", res.token[0]);
                    Cookies.set("www.stickstoff.de-competition", res.token[1], { expires: res.time} );
                } else {
                    console.log("Something went wrong")
                }
                console.log(SessionStorage.getItem("www.stickstoff.de-competition"));
                console.log(Cookies.get("www.stickstoff.de-competition"));

                // if (res?.success === true) {
                //     SessionStorage.set("test", "test");
                //     //this.$session.start();
                // }
               // this.user = res.user;
                this.isAuthenticated = true;
            } catch (err) {
                this.isAuthenticated = false;
                throw err;
            }
        },
        async checksession() {
            const tk1 = SessionStorage.getItem("www.stickstoff.de-competition");
            const tk2 = Cookies.get("www.stickstoff.de-competition");
            const res = await api.post<{ }>("src/index.php/auth/session", {
                    tk1,
                    tk2,
            });
            return res[0];
            
            
        },
        async logout() {
            try {
                await api.post("src/index.php/auth/logout", null, false);
                this.isAuthenticated = false;
            } catch (err) {
                console.error(err);
                throw err;
            }
        },
        /**
         * Tries to get the currently authenticated user.
         * If the user isn't authenticated, the call fails with status 401
         */
        async getCurrentUser() {
            try {
                //this.user = await api.get("");
                this.isAuthenticated = true;
            } catch (err) {
                this.isAuthenticated = false;
            }
        },
        async initialize() {
            await this.getCurrentUser();
            this.isInitialized = true;
        },
    },
});
