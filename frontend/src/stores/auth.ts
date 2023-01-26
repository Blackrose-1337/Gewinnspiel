import { defineStore } from "pinia";
import NetworkHelper from "@/utils/networkHelper";

const api = new NetworkHelper();

export type State = {
    isAuthenticated: boolean;
    role: string;
};

export const useAuthStore = defineStore({
    id: "auth",
    state: () =>
        ({
            isAuthenticated: false as boolean,
            isInitialized: false,
            role: '' as string,
        } as State),
    actions: {
        answerhandler(res: any) {
            this.role = res.role;
            this.isAuthenticated = res.success
            return true;
        },
        async login(email: string, password: string) {
            try {
                //test backend-valid
                // const res = await api.post<{ success: boolean; user: { email: string } }>("src/index.php/auth/login", {
                //     email: "poppel",
                //     password,
                //  });
                const res = await api.post<{ success: boolean; role: string; error: string }>("auth/login", {
                    email,
                    password,
                });
                
                if (res?.success) {
                    return this.answerhandler(res);
                } else if (res?.role) {
                    return this.answerhandler(res);
                }
            } catch (err) {
                this.isAuthenticated = false;
                throw err; 
            }
        },
        async logout() {
            try {
                const res = await api.post<{ success: boolean; role: string; error: string }>("auth/logout", null);
                if (!res?.success) {
                    document.cookie = "PHPSESSID = ; expires = Thu, 01 Jan 2000 00:00:00 GMT";
                    return this.answerhandler(res);
                }
            } catch (err) {
                console.error(err);
                throw err;
            }
        },
        async check() {
            try {
                const res = await api.get<{ success: boolean; role: string; error: string }>("auth/check");  
                if (res?.success == true) {
                    return this.answerhandler(res);
                } else {
                    this.role = '';
                    return false;
                }
            } catch (err) {
                this.isAuthenticated = false;
                throw err; 
            }
        }
    },
});
