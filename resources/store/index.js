import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        bg: {
            login: null,
            dashboard: null,
        },
        user: null,
        admin: {
            sidePanel: 0,
            selectedUser: null,
            selectedCost: null,
            selectedCourse: null,
            selectedNotice: null,

            users: [],
            notices: [],
            costs: [],
            courses: [],

        },
        reports: {
            sidePanel: 0,
        },
        ticket: {
            selected: null,
            tickProcedures: null,
        },
        client: {
            selected: null,
        },
        sale: {
            selected: null,
        },
        purchase: {
            selected: null,
        },

        adminPanel: {
            selected: null,
            Notices: null,
            Campaigns: null,
            Campaigners: null,
            CampaignScore: null,
            Users: null,
            Planner: null,
        },
        refData: {
            client: null,
            allTickets: [],
            managedItTickets: [],
            itTrainingTickets: [],
            computerCareTickets: [],

        }
    },
    getters: {

        loggedUserLevel: state => {
            if (state.user) {

                if (state.user.level == 'admin') {
                    return true;
                } else {
                    return false;
                }
            }
        },
        ticketCreatedAt: state => {
            return state.ticket.selected.created_at.substr(0, 10);
        },

        saleCreatedAt: state => {
            return state.sale.selected.created_at.substr(0, 10);
        },

        ticketBal: state => {
            return (state.ticket.selected.cost - state.ticket.selected.paid);
        },
        availableProcedures: state => { return state.ticket.tickProcedures.length; },
        userInitials: state => {

            // return state.user.name.substr(0, 1) 
            let initials = state.user.name.split(" ")[0].substr(0, 1) + state.user.name.split(" ")[1].substr(0, 1);

            return initials;

        },
        refClientName: state => { return state.refData.client.client_id },

        ticketService: state => { return state.ticket.selected.service },

        adminSelectedTab: state => { return state.admin.sidePanel },

        adminIsUserSelected: state => { if (state.admin.selectedUser == null) { return false; } else { return true; } }
    },
    mutations: {
        loggedUser(state, payload) {
            state.user = payload;
        },
        adminSelectUser(state, payload) {
            state.admin.selectedUser = payload;
        },
        adminSelectCost(state, payload) {
            state.admin.selectedCost = payload;
        },
        adminSelectNotice(state, payload) {
            state.admin.selectedNotice = payload;
        },
        adminSelectCourse(state, payload) {
            state.admin.selectedCourse = payload;
        },
        adminusers(state, payload) {
            state.admin.users = payload;
        },
        adminnotices(state, payload) {
            state.admin.notices = payload;
        },
        admincosts(state, payload) {
            state.admin.costs = payload;
        },
        admincourses(state, payload) {
            state.admin.courses = payload;
        },
        selectTicket(state, payload) {
            state.ticket.selected = payload;
        },
        selectClient(state, payload) {
            state.client.selected = payload;
        },
        selectRefClient(state, payload) {
            state.refData.client = payload;
        },
        selectSale(state, payload) {
            state.sale.selected = payload;
        },
        selectPurchase(state, payload) {
            state.purchase.selected = payload;
        },

        selectedTicketProcedures(state, payload) {
            state.ticket.tickProcedures = payload
        },

        clearProcedures(state) {
            state.ticket.tickProcedures = null;
        },
        selectAdminPanel(state, payload) {
            state.admin.sidePanel = payload;
        },
        selectReportPanel(state, payload) {
            state.reports.sidePanel = payload;
        },
        clearSelectedTicket(state) {
            state.ticket.selected = null;
        },
        clearSelectedClient(state) { state.client.selected = null; },

        clearSelectedAdminUser(state) { state.admin.selectedUser = null; },
        clearSelectedAdminCost(state) { state.admin.selectedCost = null; },
        spliceProcedures(state, payload) {
            state.ticket.tickProcedures.splice(state.ticket.tickProcedures.indexOf(payload), 1);
        },
        AddNotices(state, payload) {
            state.adminPanel.Notices = payload
        },
        AddCampaigns(state, payload) {
            state.adminPanel.Campaigns = payload
        },
        AddCampaigners(state, payload) {
            state.adminPanel.Campaigners = payload
        },
        AddCampaignScore(state, payload) {
            state.adminPanel.CampaignScore = payload
        },
        loadAllTickets(state, payload) {
            state.refData.allTickets = payload
        },
        loadManagedItTickets(state, payload) {
            state.refData.managedItTickets = payload
        },
        loadItTrainingTickets(state, payload) {
            state.refData.itTrainingTickets = payload
        },
        loadComputerCareTickets(state, payload) {
            state.refData.computerCareTickets = payload
        },
        addBgLogin(state, payload) {
            state.state.bg.login = payload
        },
    },
    actions: {}
});