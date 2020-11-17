const state = {
    step_zero: null,
    step_one: null,
    step_two: null,
    step_three: null,
    base_price: null,
    final_base_price: 0,
    current_volume: 20000,
    crop_area: null,
    seeding_rate: null,
    final_full_price: 0,

    pay_method: 2,
    season_discount: 0,

    volume_discount_result: 0,
    pay_method_result: 0,
    pay_method_result_text: '',
    season_discount_result: 0,
    akkor_member_discount_result: 0,

    summary_discount: 0,

    pay_method_discount_list: [
        {discount: 3, method: "100% предоплата", id: 0},
        {discount: 2, method: "75% / 25% предоплата", id: 1},
        {discount: 0, method: "Другое", id: 2}
    ],
    season_discount_list: [
        {discount: 5, month_from: 11, month_to: 12, id: 1},
        {discount: 3, month_from: 12, month_to: 1, id: 2},
        {discount: 2, month_from: 1, month_to: 3, id: 3},
        {discount: 0, month_from: 3, month_to: 11, id: 0},
    ],
    volume_discount_list: [
        {discount: 0, from_vol: 0, to_vol: 200},
        {discount: 0.5, from_vol: 200, to_vol: 500},
        {discount: 1, from_vol: 500, to_vol: 1000},
        {discount: 1.5, from_vol: 1000, to_vol: 2000},
        {discount: 2.0, from_vol: 2000, to_vol: 3000},
        {discount: 2.5, from_vol: 3000, to_vol: 5000},
        {discount: 3.0, from_vol: 5000, to_vol: 7000},
        {discount: 3.5, from_vol: 7000, to_vol: 10000},
        {discount: 4.0, from_vol: 10000, to_vol: 15000},
        {discount: 4.5, from_vol: 15000, to_vol: 20000},
        {discount: 5.0, from_vol: 20000, to_vol: null},
    ],
    is_discount_for_AKKOR_members: false,
}

// getters
const getters = {
    One: (state, getters, rootState) => {
        return state.step_one;
    },
    Two: (state, getters, rootState) => {
        return state.step_two;
    },
    Three: (state, getters, rootState) => {
        return state.step_three;
    },
    Zero: (state, getters, rootState) => {
        return state.step_zero;
    },
    GetSeedingRate: (state, getters, rootState) => {
        return state.seeding_rate
    },
    GetVegetationCount: (state, getters, rootState) => {
        console.log(state.step_one.vegetation.length)
        return state.step_one.vegetation.length
    },
    GetCropArea: (state, getters, rootState) => {
        return state.crop_area
    },
    GetSummaryDiscount: (state, getters, rootState) => {
        return state.summary_discount
    },
    GetPayMethodDiscountList: (state, getters, rootState) => {
        return state.pay_method_discount_list
    },
    GetVolumeDiscountList: (state, getters, rootState) => {
        return state.volume_discount_list
    },
    GetSeasonDiscountList: (state, getters, rootState) => {
        return state.season_discount_list
    },
    GetCurrentVolume: (state, getters, rootState) => {
        return state.current_volume
    },
    GetBasePrice: (state, getters, rootState) => {

        state.final_base_price = state.base_price

        let volume_discount = 0;

        for (let index in state.volume_discount_list) {
            let item = state.volume_discount_list[index];
            let res = (item.to_vol != null ?
                item.from_vol <= state.current_volume && item.to_vol >= state.current_volume :
                item.from_vol <= state.current_volume)

            if (res)
                volume_discount = item.discount / 100
        }

        state.volume_discount_result = volume_discount

        /*  const d = new Date();
          let season_discount = 0;
          for(let index in state.season_discount_list) {
              let item = state.season_discount_list[index];
              let res = (item.month_from >= d.getMonth() && item.month_from <= d.getMonth())

              if (res)
                  season_discount = item.discount / 100
          }*/

        let season_discount = 0;
        for (let index in state.season_discount_list) {
            let item = state.season_discount_list[index];
            let res = (item.id === state.season_discount)

            if (res)
                season_discount = item.discount / 100
        }

        state.season_discount_result = season_discount

        let discount_for_AKKOR_members = (state.is_discount_for_AKKOR_members ? 10 : 0) / 100

        state.akkor_member_discount_result = discount_for_AKKOR_members;

        let pay_method_discount = 0;

        for (let index in state.pay_method_discount_list) {
            let item = state.pay_method_discount_list[index];
            let res = (item.id === state.pay_method)

            if (res) {
                pay_method_discount = item.discount / 100
                state.pay_method_result_text = item.method
            }
        }
        state.pay_method_result = pay_method_discount


        state.final_base_price -= (
            (state.base_price * volume_discount) +
            (state.base_price * season_discount) +
            (state.base_price * discount_for_AKKOR_members) +
            (state.base_price * pay_method_discount)
        )

        state.summary_discount = ((volume_discount + season_discount + discount_for_AKKOR_members + pay_method_discount) * 100).toFixed(2);


        return state.final_base_price.toFixed(2);
    }

}

// actions
const actions = {
    setStepZero({state, commit}, data) {
        commit('setStepZero', data)
    },
    setStepOne({state, commit}, data) {
        commit('setStepOne', data)
    },
    setStepTwo({state, commit}, data) {
        commit('setStepTwo', data)
    },
    setStepThree({state, commit}, data) {
        commit('setStepThree', data)
    },
    setIsAkkorMember({state, commit}, data) {
        state.is_discount_for_AKKOR_members = data

    },
    setPayMethod({state, commit}, data) {
        state.pay_method = data
    },
    setSeasonDiscount({state, commit}, data) {
        state.season_discount = data
    },
    setBasePrice({state, commit}, data) {
        state.base_price = data
    },
    setSeedingRate({state, commit}, data) {
        commit('setSeedingRate', data)
    },
    submitResult({state, commit}, type) {
        commit('submitResult', type)
    },

}

// mutations
const mutations = {
    submitResult(state, payload) {

        axios
            .post('m/mail.php', {
                type: payload,
                name: state.step_zero.name,
                phone: state.step_zero.phone,
                email: state.step_zero.email,
                invite: state.step_zero.invite,
                company: state.step_zero.company,
                volume: state.current_volume,
                base_price: state.base_price,
                volume_discount: state.volume_discount_result * 100,
                season_discount: state.season_discount_result * 100,
                akkor_member_discount: state.akkor_member_discount_result * 100,
                pay_method_discount: state.pay_method_result * 100,
                pay_method: state.pay_method_result_text,
                summary_discount: state.summary_discount,
                discount_in_money: state.base_price - state.final_base_price, //скидка в рублях
                base_price_with_discount: state.final_base_price,
                full_price: state.final_base_price * state.current_volume,

                crop_area: state.step_one.crop_area,
                prepare_volume: state.step_one.prepare.required_volume,
                prepare_volume_price: state.step_one.prepare.required_volume * state.base_price,
                planned_yield: state.step_three.planned_yield,
                yield_cost: state.step_three.yield_cost,
                seeding_rate: state.step_three.seeding_rate,

                first_volume: state.step_one.vegetation.length >= 1 ? state.step_one.vegetation[0].required_volume : 0,
                first_volume_price: state.step_one.vegetation.length >= 1 ? state.step_one.vegetation[0].required_volume * state.base_price : 0,
                second_volume: state.step_one.vegetation.length >= 2 ? state.step_one.vegetation[1].required_volume : 0,
                second_volume_price: state.step_one.vegetation.length >= 2 ? state.step_one.vegetation[1].required_volume * state.base_price : 0,
                third_volume: state.step_one.vegetation.length >= 3 ? state.step_one.vegetation[2].required_volume : 0,
                third_volume_price: state.step_one.vegetation.length >= 3 ? state.step_one.vegetation[2].required_volume * state.base_price : 0,
                farm_investments_volume: state.current_volume,
                farm_investments_price: state.current_volume * state.base_price,
                increase_in_yield_1: state.step_three.incrace_rate,
                increase_in_yield_2: state.step_three.increase_centners,
                increase_in_money: state.step_three.increase_in_money,
                net_profit: state.step_three.net_profit,
                profitability: state.step_three.profitability,


            }, {responseType: 'blob'}).then(resp => {
            FileDownload(resp.data, 'report.pdf');
            //window.open(resp.data.filename, "_blank");
        });
    },
    setSeedingRate(state, payload) {
        state.seeding_rate = payload

        if (state.step_one != null)
            state.step_one.prepare.seeding_rate = payload
    },
    setStepZero(state, payload) {
        state.step_zero = payload;
    },
    setStepOne(state, payload) {
        state.step_one = payload;
        state.current_volume = payload.summary_required_volume
        state.crop_area = payload.crop_area


    },
    setStepTwo(state, payload) {
        state.step_two = payload;
    },
    setStepThree(state, payload) {
        state.step_three = payload;
    }

}

export default {
    state,
    getters,
    actions,
    mutations
}
