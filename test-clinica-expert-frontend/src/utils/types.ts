
export type ShortLink = {
    id: string,
    identifier: string,
    url: string,
    urlShort: string,
    hits: number
}

export type Stats = {
    'hits': number,
    'links': number
}

export type Errors = {errors: {url: string, identifier: string}}

export declare interface OrderShortLinks {
    [key: string]: string; // Defina o tipo das chaves e valores conforme necessário
}
