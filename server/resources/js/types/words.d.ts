export interface Word {
    id: number;
    word: string;
    meanings: { explanation: string; title: string }[];
    partOfSpeech: string;
    baseForm?: WordRelation;
    views?: number;
    wordSynonyms: WordRelation[];
    wordAntonyms: WordRelation[];
}

export interface WordRelation {
    word: string;
    id: number;
}

export interface TableWordResponse {
    current_page: number;
    data: Word[];
    first_page_url: string;
    from: number;
    last_page: number;
    last_page_url: string;
    links: {
        url: string | null;
        label: string;
        active: boolean;
    }[];
    next_page_url: string | null;
    path: string;
    per_page: number;
    prev_page_url: string | null;
    to: number;
    total: number;
}
