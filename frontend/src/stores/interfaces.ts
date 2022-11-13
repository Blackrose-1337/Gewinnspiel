import type { EmbeddedValidationRule } from "quasar";



export interface User {
    id: number;
    name: string;
    surname: string;
    role: string;
    mail: string;
    land: string;
    plz: number;
    ortschaft: string;
    strasse: string;
    strNr: number;
    tel: number;
    pwSaltId: number;
}
export interface Project {
    id: number;
    userID: number;
    text: string;
    title: string;
}

export interface Competition {
    project: Project
    user : User
}


export interface ProjectBild {
    id: number;
    projectId: number;
    bildPfad: string;
}


export interface CompetitionDetails {
    id: number;
    title: string;
    text: string;
    teilnehmerbedingung: string;
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
