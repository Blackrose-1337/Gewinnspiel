import type { EmbeddedValidationRule } from "quasar";



export interface User {
    id: number;
    name: string;
    surname: string;
    role: string;
    mail: string;
}
export interface Project {
    id: number;
    userID: number;
    uderBildID: number[];
}

export interface Wettbewerb {
    id: number;
    title: string;
    Wettbewerbtext: string;
    Wettbewerbbeginn: Date;
    Wettbewerbende: Date;
    WettbewerbCloseText: string;
}

export interface Bewertung{
    id: number;
    projectId: number;
    bewertung: [{
        kriteriumId: number;
        bewertung: number;
    }]
}
