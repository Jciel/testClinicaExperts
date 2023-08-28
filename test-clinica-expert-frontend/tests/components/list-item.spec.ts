import {describe, expect, test} from "vitest"
import ListItem from "../../src/components/ListItem.vue";
import {mount} from "@vue/test-utils";


describe("Test ListItem.vue component", () => {
    test('mount component', async () => {
        expect(ListItem).toBeTruthy()

        const wrapper = mount(ListItem, {
            props: {
                shortLink: {
                    name: "shortLinkUrl",
                    url: "www.google.com.br",
                    shortUrl: "gg",
                    hits: 23
                }
            }
        })

        expect(wrapper.html()).toMatchSnapshot()

        const linkName = wrapper.find('.link-name')
        const shortLinkUrl = wrapper.find('.short-link')

        expect(linkName.text()).toStrictEqual('shortLinkUrl')
        expect(shortLinkUrl.text()).toStrictEqual('gg')
    })

    test('test if emit a delete event when delete icon is clicled', async () => {
        const wrapper = mount(ListItem, {
            props: {
                shortLink: {
                    name: "shortLinkUrl",
                    url: "www.google.com.br",
                    shortUrl: "gg",
                    hits: 23
                }
            }
        })

        await wrapper.find('.delete').trigger('click')
        expect(wrapper.emitted('delete'))
    })
})
