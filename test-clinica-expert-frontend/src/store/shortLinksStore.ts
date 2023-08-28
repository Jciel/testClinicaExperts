import { defineStore, StateTree } from "pinia";
import { OrderShortLinks, ShortLink, Stats } from "../utils/types.ts";

const urlApiBase = import.meta.env.VITE_API_BASE;
const urlApi = import.meta.env.VITE_API;
export const useShortLinkStore = defineStore('shortLinks', {
    state: (): StateTree => {
      return {
        shortLinks: [] as Array<ShortLink>,
        stats: {} as Stats
      }
    },

    getters: {
        getShortLinks: (state: StateTree) => state.shortLinks,
        getStats: (state: StateTree) => state.stats
    },

    actions: {
        fetchShortLinks(page: number = 1, orders: OrderShortLinks) {
            const queryString = Object.keys(orders)
                .map((key: string) => `${encodeURIComponent(key)}=${encodeURIComponent(orders[key])}`)
                .join('&');

            fetch(`${urlApiBase}/list?page=${page}&${queryString}`, {method: 'GET',})
                .then(res => res.json())
                .then(result => {
                    this.$state.shortLinks = result.data.map((shortLink: ShortLink) => mountShortLink(shortLink))
                })
                .catch(err => {
                    console.log(err)
                    throw err
                })
        },

        fetchStats() {
            fetch(`${urlApiBase}/get-stats`, {method: 'GET',})
                .then(res => res.json())
                .then(result => {
                    this.$state.stats = result
                })
                .catch(err => {
                    console.log(err)
                    throw err
                })
        },

        async createShortLink(url: string, identifier: string) {
            return fetch(`${urlApiBase}/create`, {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({"url": url, "identifier": identifier})
            }).then(res => res.json())
                .then(data => {
                    if (data.errors) return data

                    const shortLink: ShortLink = mountShortLink(data)
                    this.$state.shortLinks = [shortLink].concat(this.$state.shortLinks)
                    return shortLink
                })
                .catch(err => {
                console.log('err: ', err)
                throw err
            })
        },

        searchUrl(url: string) {
            fetch(`${urlApiBase}/search`, {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({"url": url})
            }).then(res => res.json())
                .then(result => {
                    this.$state.shortLinks = result.map((shortLink: ShortLink) => mountShortLink(shortLink))
                })
                .catch(err => {
                    console.log(err)
                    throw err
                })
        },

        deleteShortLink(id: string) {
            fetch(`${urlApiBase}/delete/${id}`, {method: 'DELETE'})
                .then(res => {
                    if (res.status === 200) {
                        this.$state.shortLinks = this.$state.shortLinks.filter((item: ShortLink) => !(item.id === id))
                    }
                }).catch(err => {
                    throw err
                })
        },

        accessLink(id: string) {
            fetch(`${urlApi}/${id}`, { method: 'GET' })
                .then(res => {
                    return res.json()
                })
                .then(() => {
                    this.$state.shortLinks = this.$state.shortLinks.map((item: ShortLink) => {
                        if (item.identifier === id) {
                            return mountShortLink(item)
                        }
                        return item;
                    })
                })
                .catch(err => {
                    throw err
                })
        }
    }
})


function mountShortLink (data: ShortLink): ShortLink {
    return {
        "id": data.id,
        "identifier": data.identifier,
        "url": data.url,
        "urlShort": data.urlShort,
        "hits": data.hits
    }
}
