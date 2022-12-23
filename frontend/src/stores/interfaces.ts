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
    userId: number;
    text: string;
    title: string;
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
    wettbewerbbeginn: string;
    wettbewerbende: string;
    wettbewerbCloseText: string;
}

export interface Bewertung{
    id: number;
    projectId: number;
    kriterienId: number;
    bewertung: number;
}

export interface Kriterien{
    id: number;
    frage: string;
    value: number;
} 
