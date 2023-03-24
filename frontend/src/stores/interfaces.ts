export interface User {
    id: number;
    name: string;
    surname: string;
    role: string;
    email: string;
    land: string;
    plz: number;
    ortschaft: string;
    strasse: string;
    strNr: number;
    tel: number;
    vorwahl: number;
}
export interface Project {
    id: number;
    userId: number;
    text: string;
    title: string;
    pics: string[];
    finish: number;
}

export interface Competition {
    project: Project;
    user: User;
    pics: ProjectBild[];
}

export interface ProjectBild {
    id: number;
    projectId: number;
    bildbase: string;
}

export interface CompetitionDetails {
    id: number;
    title: string;
    text: string;
    teilnehmerbedingung: string;
    wettbewerbbeginn: Date;
    wettbewerbende: Date;
    wettbewerbCloseText: string;
}

export interface Bewertung {
    id: number;
    projectId: number;
    kriterienId: number;
    bewertung: number | null;
    finish: number;
}

export interface Kriterien {
    id: number;
    frage: string;
    value: number | null;
}
export interface Auswertung {
    id: number;
    userId: number;
    name: string;
    surname: string;
    mail: string;
    value: number;
    finish: boolean;
}
export interface Message {
    exsits: number;
    meldung: string;
}
