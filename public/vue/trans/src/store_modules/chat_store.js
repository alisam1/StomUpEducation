const settings = {
    state: {
        currentPanel: "chatPanel",
        currentPanelMembers: "all",
        
        people: [
            {firstName: "Александр",
             lastName: "Иванов",
             imgUrl: "https://neomed-clinic.ru/wp-content/uploads/2017/04/andgel1.jpg",
             awaiting: "true",
            },
            {firstName: "Александр",
             lastName: "Иванов",
             imgUrl: "https://neomed-clinic.ru/wp-content/uploads/2017/04/andgel1.jpg",
             awaiting: "false",
            },
            {firstName: "Александр",
             lastName: "Иванов",
             imgUrl: "https://neomed-clinic.ru/wp-content/uploads/2017/04/andgel1.jpg",
             awaiting: "false",
            },
            {firstName: "Александр",
             lastName: "Иванов",
             imgUrl: "https://neomed-clinic.ru/wp-content/uploads/2017/04/andgel1.jpg",
             awaiting: "true",
            },
            {firstName: "Александр",
             lastName: "Иванов",
             imgUrl: "https://neomed-clinic.ru/wp-content/uploads/2017/04/andgel1.jpg",
             awaiting: "false",
            },
            {firstName: "Александр",
             lastName: "Иванов",
             imgUrl: "https://neomed-clinic.ru/wp-content/uploads/2017/04/andgel1.jpg",
             awaiting: "false",
            },
        ],
        
        messages: [],
        
        lastSender: "0",
    },
    actions: {
        SET_CURRENT_PANEL({commit}, newCurrentPanel) {commit("setCurrentPanel", newCurrentPanel);},
        SET_CURRENT_PANEL_MEMBERS({commit}, newCurrentPanelMembers) {commit("setCurrentPanelMembers", newCurrentPanelMembers);},
        
        PUSH_MESSAGE({commit}, newMessage) {commit("pushMessage", newMessage);},
        SET_LAST_SENDER({commit}, newLastSender) {commit("setLastSender", newLastSender);},
    },
    mutations: {
        setCurrentPanel (state, newCurrentPanel) {state.currentPanel = newCurrentPanel;},
        setCurrentPanelMembers (state, newCurrentPanelMembers) {state.currentPanelMembers = newCurrentPanelMembers;},
        
        pushMessage (state, newMessage) {state.messages = state.messages.concat(newMessage);},
        setLastSender (state, newLastSender) {state.lastSender = newLastSender;},
    },
    getters: {
        getCurrentPanel(state) {return state.currentPanel;},
        getCurrentPanelMembers(state) {return state.currentPanelMembers;},
        
        getPeople(state) {return state.people;},
        getPeopleInvited(state) {return state.people.filter(person => person.awaiting == "true")},
        getPeopleInvolved(state) {return state.people.filter(person => person.awaiting == "false")},
        
        getMessages(state) {return state.messages},
        getLastSender(state) {return state.lastSender},
    }
};
 
export default settings;