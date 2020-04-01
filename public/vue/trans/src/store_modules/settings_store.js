const settings = {
    state: {
        currentQuality: "480q",
        isCameraActive: true,
    },
    actions: {
        SET_QUALITY({commit}, newQuality) {commit("setQuality", newQuality);},
        SET_ISCAMERAACTIVE({commit}, newValue) {commit("setIsCameraActive", newValue);},
    },
    mutations: {
        setQuality (state, newQuality) {state.currentQuality = newQuality;},
        setIsCameraActive (state, newValue) {state.isCameraActive = newValue;},
    },
    getters: {
        getCurrentQuality(state) {return state.currentQuality;},
        getIsCameraActive(state) {return state.isCameraActive;},
    }
};
 
export default settings;