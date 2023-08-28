import {describe, expect, test} from "vitest";
import StatInfo from "../../src/components/StatInfo.vue";
import {mount} from "@vue/test-utils";


describe("Test StatInfo.vue component", () => {
    test("Mount component", async () => {
        expect(StatInfo).toBeTruthy()

        const wrapper = mount(StatInfo, {
            props: {
                value: "23",
                text: "Clicks"
            }
        })

        expect(wrapper.html()).toMatchSnapshot()

        const value = wrapper.find('.value')
        const text = wrapper.find('.text')

        expect(value.text()).toStrictEqual('23')
        expect(text.text()).toStrictEqual('Clicks')
    })
})
