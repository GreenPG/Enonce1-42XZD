"use strict";
var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
var __generator = (this && this.__generator) || function (thisArg, body) {
    var _ = { label: 0, sent: function() { if (t[0] & 1) throw t[1]; return t[1]; }, trys: [], ops: [] }, f, y, t, g;
    return g = { next: verb(0), "throw": verb(1), "return": verb(2) }, typeof Symbol === "function" && (g[Symbol.iterator] = function() { return this; }), g;
    function verb(n) { return function (v) { return step([n, v]); }; }
    function step(op) {
        if (f) throw new TypeError("Generator is already executing.");
        while (_) try {
            if (f = 1, y && (t = op[0] & 2 ? y["return"] : op[0] ? y["throw"] || ((t = y["return"]) && t.call(y), 0) : y.next) && !(t = t.call(y, op[1])).done) return t;
            if (y = 0, t) op = [op[0] & 2, t.value];
            switch (op[0]) {
                case 0: case 1: t = op; break;
                case 4: _.label++; return { value: op[1], done: false };
                case 5: _.label++; y = op[1]; op = [0]; continue;
                case 7: op = _.ops.pop(); _.trys.pop(); continue;
                default:
                    if (!(t = _.trys, t = t.length > 0 && t[t.length - 1]) && (op[0] === 6 || op[0] === 2)) { _ = 0; continue; }
                    if (op[0] === 3 && (!t || (op[1] > t[0] && op[1] < t[3]))) { _.label = op[1]; break; }
                    if (op[0] === 6 && _.label < t[1]) { _.label = t[1]; t = op; break; }
                    if (t && _.label < t[2]) { _.label = t[2]; _.ops.push(op); break; }
                    if (t[2]) _.ops.pop();
                    _.trys.pop(); continue;
            }
            op = body.call(thisArg, _);
        } catch (e) { op = [6, e]; y = 0; } finally { f = t = 0; }
        if (op[0] & 5) throw op[1]; return { value: op[0] ? op[1] : void 0, done: true };
    }
};
function createStateStore(_a) {
    var survey = _a.survey, nonce = _a.nonce, apiBase = _a.apiBase, language = _a.language;
    return Vue.observable({
        config: {
            nonce: nonce,
            language: language,
            apiBase: apiBase,
        },
        survey: survey,
        sectionUid: survey.sections[0].uid,
        entry: {},
        variables: {},
        lastEntry: {},
        fieldsErrors: {},
        globalError: "",
        loading: {},
        navigation: [survey.sections[0].uid],
    });
}
function createStateActions(store) {
    return {
        dismissFieldsErrors: function () {
            store.fieldsErrors = {};
        },
        dismissErrors: function () {
            this.dismissFieldsErrors();
            this.dismissGlobalError();
        },
        dismissGlobalError: function () {
            store.globalError = null;
        },
        getFieldError: function (fieldUid) {
            return store.fieldsErrors[fieldUid] || "";
        },
        getGlobalError: function () {
            return store.globalError || "";
        },
        setGlobalError: function (error) {
            store.globalError = error;
        },
        setFieldError: function (fieldUid, error) {
            Vue.set(store.fieldsErrors, fieldUid, error);
        },
        setSectionUid: function (sectionUid) {
            if (sectionUid !== store.navigation[store.navigation.length - 1]) {
                store.navigation.push(sectionUid);
            }
            store.sectionUid = sectionUid;
            this.persist();
        },
        getSectionUid: function () {
            return store.sectionUid;
        },
        getSection: function (sectionUid) {
            return store.survey.sections.find(function (section) { return section.uid === sectionUid; });
        },
        getCurrentSection: function () {
            return store.survey.sections[this.getSectionIndex()];
        },
        getNextSection: function () {
            return store.survey.sections[this.getSectionIndex() + 1];
        },
        getPreviousSection: function () {
            return store.survey.sections[this.getSectionIndex() - 1];
        },
        getSectionIndex: function () {
            return store.survey.sections.findIndex(function (section) { return section.uid === store.sectionUid; });
        },
        getFirstSection: function () {
            return store.survey.sections[0] || null;
        },
        getLastSection: function () {
            return store.survey.sections[store.survey.sections.length - 1] || null;
        },
        isSectionUid: function (sectionUid) {
            return store.sectionUid === sectionUid;
        },
        isFirstSection: function () {
            var _a;
            return ((_a = this.getPreviousSection()) === null || _a === void 0 ? void 0 : _a.uid) !== "welcome";
        },
        isLastSection: function () {
            var _a;
            return ((_a = this.getNextSection()) === null || _a === void 0 ? void 0 : _a.uid) === "thankyou";
        },
        isStarted: function () {
            return this.getSectionIndex() > 0;
        },
        isFinished: function () {
            return store.sectionUid === "thankyou";
        },
        navigateToNextSection: function () {
            var _a;
            this.setSectionUid((_a = this.getNextSection()) === null || _a === void 0 ? void 0 : _a.uid);
        },
        navigateToPreviousSection: function () {
            store.navigation.pop();
            if (store.navigation.length >= 1) {
                this.setSectionUid(store.navigation[store.navigation.length - 1]);
            }
        },
        getLastEntry: function () {
            return store.lastEntry;
        },
        setLastEntry: function (entry) {
            var _this = this;
            if (entry.customThankYouMessage) {
                var regex = new RegExp(/{{ variable\(\'(.+?)\', \'(\w*)\'\) }}/gm);
                entry.customThankYouMessage = entry.customThankYouMessage.replace(regex, function (matches, uid, fallback) {
                    return _this.getVariable(uid) || fallback;
                });
            }
            store.lastEntry = entry;
            this.persist();
        },
        setEntryDataItem: function (name, value) {
            store.entry[name] = value;
            this.persist();
        },
        setEntryData: function (data) {
            Object.entries(data).forEach(function (pair) { return (store.entry[pair[0]] = pair[1]); });
            this.persist();
        },
        getEntryDataItem: function (name) {
            return store.entry[name] || [];
        },
        getEntryData: function () {
            return Object.entries(store.entry);
        },
        getEntryDataAsFormData: function () {
            var formData = new FormData();
            formData.set("survey_uid", store.survey.uid);
            formData.set("language", store.config.language);
            Object.entries(store.entry).forEach(function (pair) {
                pair[1].forEach(function (value) { return formData.append(pair[0], value); });
            });
            return formData;
        },
        getEntry: function () {
            return store.entry;
        },
        resetEntry: function () {
            store.entry = {};
        },
        setScoring: function (scoring) {
            Vue.set(store, "scoring", scoring);
        },
        setVariable: function (name, value) {
            Vue.set(store.variables, name, value);
            this.persist();
        },
        getVariable: function (name, fallback) {
            if (fallback === void 0) { fallback = ""; }
            return store.variables[name] || fallback;
        },
        startLoading: function (id) {
            if (id === void 0) { id = "global"; }
            Vue.set(store.loading, id, true);
        },
        stopLoading: function (id) {
            if (id === void 0) { id = "global"; }
            Vue.set(store.loading, id, false);
        },
        isLoading: function (id) {
            if (id === void 0) { id = "global"; }
            return Boolean(store.loading[id]);
        },
        persist: function () {
            if (store.survey.preview) {
                return;
            }
            localStorage.setItem("draft:".concat(store.survey.uid), JSON.stringify({
                entry: store.entry,
                variables: store.variables,
                lastEntry: store.lastEntry,
                sectionUid: store.sectionUid,
                navigation: store.navigation,
            }));
        },
        restore: function (element) {
            var storedState = JSON.parse(localStorage.getItem("draft:".concat(store.survey.uid)) || "{}");
            store.entry = (storedState === null || storedState === void 0 ? void 0 : storedState.entry) || store.entry;
            store.variables = (storedState === null || storedState === void 0 ? void 0 : storedState.variables) || store.variables;
            store.lastEntry = (storedState === null || storedState === void 0 ? void 0 : storedState.lastEntry) || store.lastEntry;
            store.navigation = (storedState === null || storedState === void 0 ? void 0 : storedState.navigation) || store.navigation;
            store.sectionUid = !this.canRestart() ? "thankyou" : (storedState === null || storedState === void 0 ? void 0 : storedState.sectionUid) || store.sectionUid;
            Object.entries(store.entry).forEach(function (pair) {
                var inputs = element.querySelectorAll("[name=\"".concat(pair[0], "\"]"));
                inputs.forEach(function (input, inputIndex) {
                    var type = input.getAttribute("type");
                    if (type === "radio" || type === "checkbox") {
                        input.checked = pair[1].includes(input.value);
                    }
                    else if (type === "file") {
                    }
                    else {
                        input.value = pair[1][inputIndex] || null;
                    }
                });
            });
        },
        resetNavigation: function () {
            store.navigation = [store.survey.sections[0].uid];
        },
        reset: function (element) {
            this.resetEntry();
            this.dismissErrors();
            element.querySelectorAll("form").forEach(function (form) { return form.reset(); });
            this.resetNavigation();
            localStorage.removeItem("draft:".concat(store.survey.uid));
            element.parentElement.scrollIntoView({ behavior: "smooth" });
        },
        enableRestart: function () {
            store.survey.canRestart = true;
        },
        disableRestart: function () {
            store.survey.canRestart = false;
        },
        canRestart: function () {
            if (store.survey.hasOwnProperty("canRestart")) {
                return store.survey.canRestart;
            }
            return true;
        },
        canViewEntry: function () {
            var _a;
            return ((_a = store.survey.settings.can_view_entry) === null || _a === void 0 ? void 0 : _a.enabled) || false;
        },
        validateSection: function (sectionFormData) {
            return __awaiter(this, void 0, void 0, function () {
                return __generator(this, function (_a) {
                    return [2, jQuery
                            .ajax({
                            url: "".concat(store.config.apiBase, "/survey/section"),
                            headers: store.config.nonce ? { "X-WP-Nonce": store.config.nonce } : {},
                            type: "post",
                            processData: false,
                            contentType: false,
                            enctype: "multipart/form-data",
                            data: sectionFormData,
                        })
                            .always(function (e) { return (e.responseJSON = jQuery.parseJSON(e.responseText)); })];
                });
            });
        },
        submitEntry: function (entryFormData) {
            if (entryFormData === void 0) { entryFormData = this.getEntryDataAsFormData(); }
            return __awaiter(this, void 0, void 0, function () {
                return __generator(this, function (_a) {
                    return [2, jQuery
                            .ajax({
                            url: "".concat(store.config.apiBase, "/entry"),
                            headers: store.config.nonce ? { "X-WP-Nonce": store.config.nonce } : {},
                            type: "post",
                            processData: false,
                            contentType: false,
                            enctype: "multipart/form-data",
                            data: entryFormData,
                        })
                            .always(function (e) { return (e.responseJSON = jQuery.parseJSON(e.responseText)); })];
                });
            });
        },
    };
}
function createState(config) {
    var $store = createStateStore(config);
    return {
        $store: $store,
        $actions: createStateActions($store),
    };
}
function serializeFormData(data) {
    var serialized = {};
    data.forEach(function (value, key) {
        if (!Reflect.has(serialized, key)) {
            serialized[key] = value;
            return;
        }
        if (!Array.isArray(serialized[key])) {
            serialized[key] = [serialized[key]];
        }
        serialized[key].push(value);
    });
    return serialized;
}
var Question = {
    name: 'question',
    inject: ['survey', 'section', '$actions', 'variable'],
    props: {
        uid: { type: String, default: '' },
        index: { type: Number, default: 0 }
    },
    computed: {
        question: function () {
            var _this = this;
            var _a, _b;
            return (_b = (_a = this.section) === null || _a === void 0 ? void 0 : _a.blocks) === null || _b === void 0 ? void 0 : _b.find(function (question) { return question.uid === _this.uid; });
        },
        isRequired: function () {
            var _a, _b, _c;
            return (_c = (_b = (_a = this.question) === null || _a === void 0 ? void 0 : _a.field.validations) === null || _b === void 0 ? void 0 : _b.required) === null || _c === void 0 ? void 0 : _c.enabled;
        },
        error: function () {
            var _a;
            return this.$actions.getFieldError((_a = this.question) === null || _a === void 0 ? void 0 : _a.field.uid);
        }
    }
};
var SectionItem = {
    name: 'section-item',
    inject: ['survey', '$actions', '$store'],
    provide: function () {
        return {
            section: this.section,
            variable: this.variable
        };
    },
    props: {
        uid: { type: String, default: '' },
        index: { type: Number, default: 0 },
    },
    computed: {
        section: function () {
            return this.$actions.getSection(this.uid);
        },
        isVisible: function () {
            return this.$actions.isSectionUid(this.uid);
        },
        shouldSubmit: function () {
            return this.$actions.isLastSection();
        },
        scoring: function () {
            return this.$store.scoring;
        },
        canRestart: function () {
            return this.$actions.canRestart();
        },
        canPrint: function () {
            return this.$actions.canPrint();
        },
        canViewEntry: function () {
            return this.$actions.canViewEntry();
        },
        lastEntry: function () {
            return this.$actions.getLastEntry();
        }
    },
    components: {
        question: Question
    },
    methods: {
        reload: function () {
            this.$emit('reload', this);
        },
        restart: function () {
            this.$emit('restart', this);
        },
        previous: function () {
            this.$emit('previous', this);
        },
        next: function () {
            this.$emit('next', this);
        },
        variable: function (blockUid, fallback) {
            if (fallback === void 0) { fallback = ''; }
            return this.$actions.getVariable(blockUid, fallback);
        },
        submit: function ($event) {
            var formData = new FormData($event.currentTarget);
            formData.set('survey_uid', this.survey.uid);
            formData.set('section_uid', this.uid);
            var data = {};
            formData.forEach(function (value, key) {
                if (!data.hasOwnProperty(key)) {
                    data[key] = [];
                }
                data[key].push(value);
            });
            this.$emit('submit', { data: data, formData: formData });
        },
        input: function ($event) {
            var _a;
            var variableName = $event.target.dataset.variableName || $event.target.id;
            var variableValue = $event.target.dataset.variableValue || ($event.target.type === 'file' ? '' : $event.target.value);
            if ($event.target.tagName === 'SELECT') {
                variableValue = $event.target.querySelector("option[value=\"".concat(variableValue, "\"]")).innerText;
            }
            if ($event.target.tagName === 'INPUT' && $event.target.type === 'checkbox') {
                variableValue = [];
                this.$el.querySelectorAll("input[name=\"".concat($event.target.name, "\"]:checked"))
                    .forEach(function (checkbox) { return variableValue.push(checkbox.dataset.variableValue); });
                variableValue = variableValue.join(', ');
            }
            if ($event.target.tagName === 'INPUT' && $event.target.type === 'radio') {
                var blockId = $event.target.name.match(/\[(.*?)\]/)[1];
                var element = this.$el.querySelector(".matrix-container input[type=\"hidden\"][data-variable-name*=\"".concat(blockId, "\"]"));
                if (element) {
                    var event_1 = new Event('input', {
                        bubbles: true,
                        cancelable: true,
                    });
                    element.dispatchEvent(event_1);
                }
            }
            if ($event.target.tagName === 'INPUT' && $event.target.type === 'hidden') {
                variableValue = [];
                this.$el.querySelectorAll("#matrix-".concat(variableName, " input[type=\"radio\"]:checked"))
                    .forEach(function (checkbox) {
                    variableValue.push(checkbox.dataset.variableValue);
                });
                variableValue = variableValue.join(', ');
            }
            this.$emit('input', {
                name: $event.target.name,
                value: $event.target.type === 'file' ? '' : $event.target.value,
                checked: (_a = $event.target.checked) !== null && _a !== void 0 ? _a : true,
                variableName: variableName,
                variableValue: variableValue
            });
        }
    }
};
var Sections = {
    name: "sections",
    inject: ["survey", "validateSection", "submitEntry", "$actions"],
    components: {
        sectionItem: SectionItem,
        question: Question,
    },
    methods: {
        reload: function () {
            this.$actions.reset(this.$el);
            location.reload();
        },
        restart: function () {
            this.$actions.reset(this.$el);
            this.$actions.setSectionUid(this.$actions.getFirstSection().uid);
        },
        previous: function () {
            this.$actions.navigateToPreviousSection();
        },
        next: function () {
            this.$actions.navigateToNextSection();
        },
        input: function (_a) {
            var name = _a.name, value = _a.value, variableName = _a.variableName, variableValue = _a.variableValue, _b = _a.checked, checked = _b === void 0 ? true : _b;
            if (name.endsWith("[]")) {
                value = this.$actions
                    .getEntryDataItem(name)
                    .concat([value])
                    .filter(function (item, position, entryDataItem) { return entryDataItem.indexOf(item) == position; })
                    .filter(function (item) { return item !== value || checked; });
            }
            else {
                value = [value];
            }
            this.$actions.setEntryDataItem(name, value);
            this.$actions.setVariable(variableName, variableValue);
        },
        validate: function (_a) {
            var _b;
            var data = _a.data, formData = _a.formData;
            return __awaiter(this, void 0, void 0, function () {
                var next, entry;
                return __generator(this, function (_c) {
                    switch (_c.label) {
                        case 0:
                            this.$actions.setEntryData(data);
                            return [4, this.validateSection(formData)];
                        case 1:
                            next = _c.sent();
                            if (!((next === null || next === void 0 ? void 0 : next.action) === "next" || (next === null || next === void 0 ? void 0 : next.action) === "section")) return [3, 2];
                            this.$actions.setSectionUid(next.section_uid);
                            return [3, 4];
                        case 2:
                            if (!((next === null || next === void 0 ? void 0 : next.action) === "submit")) return [3, 4];
                            return [4, this.submitEntry()];
                        case 3:
                            entry = _c.sent();
                            if (entry === null || entry === void 0 ? void 0 : entry.uid) {
                                this.$actions.reset(this.$el);
                                this.$actions.setSectionUid("thankyou");
                                this.survey.canRestart = entry.canRestart;
                                if ((_b = entry === null || entry === void 0 ? void 0 : entry.data) === null || _b === void 0 ? void 0 : _b.scoring) {
                                    this.$actions.setScoring(entry.data.scoring);
                                }
                                if (this.survey.settings.redirection.enabled &&
                                    this.survey.settings.redirection.url &&
                                    this.survey.settings.redirection.url !== "") {
                                    if (!this.survey.settings.redirection.blank_target) {
                                        top.location = this.survey.settings.redirection.url;
                                    }
                                    else {
                                        window.open(this.survey.settings.redirection.url, "_blank");
                                    }
                                }
                            }
                            _c.label = 4;
                        case 4: return [2];
                    }
                });
            });
        },
    },
};
var ProgressStatus = {
    name: 'status',
    inject: ['survey', '$actions'],
    computed: {
        progressPercentage: function () {
            if (this.$actions.getSectionIndex() === 0 && this.$actions.getFirstSection().uid === 'welcome') {
                return '0%';
            }
            var currentSectionPosition = this.$actions.getSectionIndex() + 1;
            return Math.ceil((currentSectionPosition / this.survey.sections.length) * 100) + '%';
        },
        isCompleted: function () {
            return this.progressPercentage == '100%';
        }
    }
};
var ErrorMessage = {
    name: 'error-message',
    inject: ['survey', '$actions'],
    computed: {
        error: function () {
            return this.$actions.getGlobalError();
        }
    },
    methods: {
        dismiss: function () {
            this.$actions.dismissGlobalError();
        }
    }
};
var SurveyComponent = {
    name: "survey",
    components: {
        ErrorMessage: ErrorMessage,
        ProgressStatus: ProgressStatus,
        Sections: Sections,
        SectionItem: SectionItem,
        Question: Question,
    },
    props: {
        survey: {
            type: Object,
            default: function () {
                return {};
            },
        },
        nonce: {
            type: String,
            default: null,
        },
        language: String,
        apiBase: {
            type: String,
            default: "/wp-json/totalsurvey",
        },
    },
    computed: {
        isLoading: function () {
            return this.$actions.isLoading();
        },
        isFinished: function () {
            return this.$actions.isFinished();
        },
    },
    data: function () {
        if (this.survey.settings.contents.welcome.enabled) {
            this.survey.sections.unshift({ uid: "welcome" });
        }
        this.survey.sections.push({ uid: "thankyou" });
        var data = createState({
            survey: this.survey,
            nonce: this.nonce,
            language: this.language,
            apiBase: this.apiBase
        });
        this.$actions = data.$actions;
        this.$store = data.$store;
        return {};
    },
    provide: function () {
        return {
            survey: this.survey,
            lastEntry: this.$store.lastEntry,
            validateSection: this.validateSection,
            submitEntry: this.submitEntry,
            $store: this.$store,
            $actions: this.$actions,
        };
    },
    mounted: function () {
        this.$actions.restore(this.$el);
    },
    methods: {
        validateSection: function (formData) {
            var _a;
            return __awaiter(this, void 0, void 0, function () {
                var response, e_1;
                var _this = this;
                return __generator(this, function (_b) {
                    switch (_b.label) {
                        case 0:
                            if (this.survey.preview) {
                                return [2, { action: "next", section_uid: this.$actions.getNextSection().uid }];
                            }
                            this.$actions.dismissErrors();
                            _b.label = 1;
                        case 1:
                            _b.trys.push([1, 3, , 4]);
                            this.$actions.startLoading();
                            return [4, this.$actions.validateSection(formData)];
                        case 2:
                            response = _b.sent();
                            this.$actions.stopLoading();
                            if (response.success) {
                                this.$nextTick(function () { return _this.$el.scrollIntoView({ behavior: "smooth" }); });
                                return [2, response.data];
                            }
                            else {
                                throw new Error(response.error);
                            }
                            return [3, 4];
                        case 3:
                            e_1 = _b.sent();
                            this.$actions.stopLoading();
                            this.$actions.setGlobalError(((_a = e_1.responseJSON) === null || _a === void 0 ? void 0 : _a.error) || (e_1 === null || e_1 === void 0 ? void 0 : e_1.message) || (e_1 === null || e_1 === void 0 ? void 0 : e_1.statusText) || (e_1 === null || e_1 === void 0 ? void 0 : e_1.responseText));
                            Object.entries(e_1.responseJSON.data).forEach(function (pair) { var _a; return _this.$actions.setFieldError(pair[0], (_a = pair[1]) === null || _a === void 0 ? void 0 : _a.join("\n")); });
                            this.$nextTick(function () { return _this.$el.scrollIntoView({ behavior: "smooth" }); });
                            return [2, false];
                        case 4: return [2];
                    }
                });
            });
        },
        submitEntry: function () {
            var _a;
            return __awaiter(this, void 0, void 0, function () {
                var response, e_2;
                var _this = this;
                return __generator(this, function (_b) {
                    switch (_b.label) {
                        case 0:
                            if (this.survey.preview) {
                                return [2];
                            }
                            this.$actions.dismissErrors();
                            _b.label = 1;
                        case 1:
                            _b.trys.push([1, 3, , 4]);
                            this.$actions.startLoading();
                            return [4, this.$actions.submitEntry()];
                        case 2:
                            response = _b.sent();
                            this.$actions.stopLoading();
                            if (response.success) {
                                this.$actions.setLastEntry(response.data);
                                this.$root.$emit("submit", {});
                                if (response.data.redirect) {
                                    window.location = response.data.redirect;
                                }
                                return [2, response.data];
                            }
                            else {
                                throw new Error(response.error);
                            }
                            return [3, 4];
                        case 3:
                            e_2 = _b.sent();
                            this.$actions.stopLoading();
                            this.$actions.setGlobalError(((_a = e_2.responseJSON) === null || _a === void 0 ? void 0 : _a.error) || (e_2 === null || e_2 === void 0 ? void 0 : e_2.message) || (e_2 === null || e_2 === void 0 ? void 0 : e_2.statusText) || (e_2 === null || e_2 === void 0 ? void 0 : e_2.responseText));
                            Object.entries(e_2.responseJSON.data).forEach(function (pair) { var _a; return _this.$actions.setFieldError(pair[0], (_a = pair[1]) === null || _a === void 0 ? void 0 : _a.join("\n")); });
                            this.$nextTick(function () { return _this.$el.scrollIntoView({ behavior: "smooth" }); });
                            return [2, false];
                        case 4: return [2];
                    }
                });
            });
        },
    },
};
Vue.directive("other", {
    bind: function (el) {
        jQuery('input[type="text"]', el).on("input", function () {
            jQuery("input.other", el).val(jQuery(this).val());
        });
        jQuery("input.other", el).on("change", function () {
            jQuery('input[type="text"]', el).val(jQuery(this).val());
        });
    },
});
Vue.directive("print", {
    bind: function (el) {
        el.addEventListener('click', function () {
            window.open(el.href).print();
        });
    },
});
Vue.directive("file", {
    bind: function (el, dir) {
        el.addEventListener('change', function () {
            el.parentNode.querySelector('.totalsurvey-file-label').innerText = el.files[0] ? el.files[0].name : dir.value;
        });
    },
});
document.querySelectorAll(".totalsurvey-wrapper").forEach(function (wrapperElement) {
    var template = document.querySelector("template[data-survey-uid=\"".concat(wrapperElement.getAttribute('data-survey-uid'), "\"]"));
    var host = document.createElement("div");
    host.classList.add("totalsurvey-survey");
    host.attachShadow({ mode: "open" }).append(template.content);
    wrapperElement.appendChild(host);
    host.shadowRoot.querySelectorAll("survey-style, survey-link, survey-script").forEach(function (el) {
        var style = document.createElement(el.tagName.toLowerCase().replace("survey-", ""));
        style.textContent = el.textContent;
        el.getAttributeNames().forEach(function (name) { return style.setAttribute(name, el.getAttribute(name)); });
        el.after(style);
        el.remove();
    });
    new Vue({
        el: host.shadowRoot.querySelector("#survey"),
        components: {
            survey: SurveyComponent,
        },
        mounted: function () {
            host.shadowRoot.instance = this;
            wrapperElement.querySelector('.totalsurvey-loading').remove();
        },
    });
    template.remove();
});
var SurveyInsightsQuestion = {
    name: 'survey-insights-question',
    inject: ['section'],
    props: {
        index: { type: String, default: '' },
    },
    data: function () {
        return {
            colors: [
                'rgb(231,57,52)',
                'rgb(255,129,42)',
                'rgb(255,188,26)',
                'rgb(153,183,44)',
                'rgb(57,162,61)',
                'rgba(103,58,183 ,1)',
                'rgb(76,46,181)',
                'rgb(3,118,176)',
                'rgba(14,160,176, 1)',
                'rgba(69,90,100 ,1)',
                'rgba(96,125,139 ,1)',
                'rgba(121,85,72 ,1)',
                'rgba(71,82,141, 1)',
                'rgba(69,90,100 ,1)',
                'rgba(193,97,93, 1)'
            ]
        };
    },
    computed: {
        question: function () {
            var _a;
            return (_a = this.section) === null || _a === void 0 ? void 0 : _a.blocks[this.index];
        },
        question_empty: function () {
            return this.question.total === 0;
        }
    },
    mounted: function () {
        var _this = this;
        var that = this;
        if (!this.question_empty) {
            var chartConfig_1 = {
                type: 'doughnut',
                data: {
                    labels: [],
                    datasets: [{
                            barPercentage: 1,
                            data: [],
                            fill: false,
                            backgroundColor: this.colors,
                            borderColor: ['white'],
                            width: "190px",
                            borderWidth: 3,
                        }]
                },
                options: {
                    cutoutPercentage: 70,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            align: 'center',
                            labels: {
                                font: {
                                    size: 14
                                },
                                usePointStyle: true,
                                boxWidth: 9,
                                boxHeight: 9,
                                padding: 15,
                                generateLabels: function (chart) {
                                    if (chart.data.labels.length && chart.data.datasets.length) {
                                        var pointStyle_1 = chart.legend.options.labels.pointStyle;
                                        return chart.data.labels.map(function (label, i) {
                                            var style = chart.getDatasetMeta(0).controller.getStyle(i);
                                            var item = chart.data.datasets[0].data[i];
                                            var percent = that.getPercentage(null, item, that.question.total);
                                            var text = label;
                                            if (item > 0) {
                                                text += " ".concat(percent, " (").concat(item, " out of ").concat(that.question.total, ")");
                                            }
                                            return {
                                                text: text,
                                                fillStyle: style.backgroundColor,
                                                strokeStyle: style.borderColor,
                                                lineWidth: style.borderWidth,
                                                pointStyle: pointStyle_1,
                                                hidden: !chart.getDataVisibility(i),
                                                index: i
                                            };
                                        });
                                    }
                                    return [];
                                },
                            }
                        },
                        tooltip: {
                            usePointStyle: true,
                            callbacks: {
                                label: function (context) {
                                    var index = context.dataIndex;
                                    var label = context.formattedValue || String(context.dataset.data[index]) || '';
                                    var percent = that.getPercentage(null, parseInt(label), that.question.total);
                                    return "".concat(percent, " (").concat(label, " out of ").concat(that.question.total, ")");
                                }
                            }
                        }
                    }, responsive: true,
                    maintainAspectRatio: false,
                }
            };
            if (this.question.type === 'matrix') {
                chartConfig_1.type = 'bar';
                chartConfig_1.options = {
                    plugins: {
                        legend: {
                            position: 'bottom',
                            align: 'center',
                            labels: {
                                font: {
                                    size: 14
                                },
                                usePointStyle: true,
                                boxWidth: 9,
                                boxHeight: 9,
                                padding: 15,
                            },
                        },
                        tooltip: {
                            xAlign: 'center',
                            yAlign: 'bottom',
                            usePointStyle: true,
                            callbacks: {
                                label: function (context) {
                                    return " ".concat(context.dataset.label, " :");
                                },
                                afterLabel: function (context) {
                                    var data = context.dataset.data;
                                    var label = context.formattedValue || String(data[context.dataIndex]) || '';
                                    var labelDataset = context.dataset.label;
                                    return "".concat(label, "% (").concat(that.question.values.data[labelDataset][context.dataIndex], " out of ").concat(that.question.values.criteria[context.label].total, ")");
                                }
                            }
                        }
                    },
                    indexAxis: 'y',
                    tooltips: {
                        displayColors: true,
                        display: true
                    },
                    scales: {
                        x: {
                            stacked: true,
                            gridLines: {
                                display: false,
                            },
                        },
                        y: {
                            stacked: true,
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        display: true
                    },
                    animation: {
                        delay: 0,
                        onProgress: function (chart) {
                            var chartInstance = chart.chart;
                            var ctx = chartInstance.ctx;
                            ctx.textAlign = "center";
                            ctx.font = "15px Open Sans";
                            ctx.fillStyle = "#fff";
                            Chart.helpers.each(this.data.datasets.forEach(function (dataset, i) {
                                var meta = chartInstance._metasets[i];
                                Chart.helpers.each(meta.data.forEach(function (bar, index) {
                                    var data = "".concat(dataset.data[index].toFixed(2), "%");
                                    if (dataset.data[index] !== 0) {
                                        ctx.fillText(data, bar.base + (bar.width / 2), bar.y + 4);
                                    }
                                }), this);
                            }), this);
                        }
                    },
                };
                chartConfig_1.data.datasets = [];
                chartConfig_1.data.labels = [];
                Object.keys(this.question.values.criteria).forEach(function (key) {
                    chartConfig_1.data.labels.push(key);
                });
                var $colorIndex_1 = 0;
                var percents_1 = [];
                Object.keys(this.question.values.criteria).forEach(function (key1) {
                    var criteria = _this.question.values.criteria[key1];
                    var criteriaValues = Object.entries(criteria.values);
                    criteriaValues = criteriaValues.map(function (_a) {
                        var key2 = _a[0], value = _a[1];
                        return [key2, _this.calculatePercentage(_this.question, value, criteria.total)];
                    });
                    percents_1.push(Object.fromEntries(criteriaValues));
                });
                Object.keys(this.question.values.data).forEach(function (key) {
                    chartConfig_1.data.datasets.push({
                        label: key,
                        data: percents_1.map(function (cre) {
                            return cre[key];
                        }),
                        backgroundColor: _this.colors[$colorIndex_1++]
                    });
                });
            }
            else {
                Object.keys(this.question.values).forEach(function (key) {
                    chartConfig_1.data.labels.push(key);
                    chartConfig_1.data.datasets[0].data.push(_this.question.values[key]);
                });
            }
            new Chart(this.$refs["chart-".concat(this.section.uid, "-").concat(this.index)], chartConfig_1);
        }
    },
    methods: {
        calculatePercentage: function (question, value, total) {
            if (total === void 0) { total = null; }
            if (total === null) {
                total = question.total;
            }
            return (value / total * 100);
        },
        getPercentage: function (question, value, total) {
            if (total === void 0) { total = null; }
            var result = this.calculatePercentage(question, value, total);
            if (result > 0) {
                return "".concat(result.toFixed(2), "%");
            }
            return '';
        }
    }
};
var SurveyInsightsSection = {
    name: 'survey-insights-section',
    inject: ['sections'],
    provide: function () {
        return {
            section: this.section,
        };
    },
    props: {
        uid: { type: String, default: '' },
    },
    computed: {
        section: function () {
            var _this = this;
            var _a;
            return (_a = this.sections) === null || _a === void 0 ? void 0 : _a.find(function (section) { return section.uid === _this.uid; });
        },
        empty: function () {
            return !this.section;
        }
    },
    components: {
        SurveyInsightsQuestion: SurveyInsightsQuestion
    },
    methods: {}
};
var SurveyInsightsComponent = {
    name: "survey-insights",
    components: {
        SurveyInsightsSection: SurveyInsightsSection,
        SurveyInsightsQuestion: SurveyInsightsQuestion
    },
    props: {
        sections: {
            type: Array,
            default: function () {
                return [];
            },
        },
        survey_uid: {
            type: String,
            default: function () {
                return '';
            },
        },
        embed: {
            type: String,
            default: function () {
                return '';
            },
        }
    },
    provide: function () {
        return {
            sections: this.sections,
        };
    },
    mounted: function () {
        if (this.embed == "1") {
            var embedBehavior = new EmbedResizingBehaviour({ uid: this.survey_uid });
            embedBehavior.postHeight();
        }
    },
    methods: {},
};
var EmbedResizingBehaviour = (function () {
    function EmbedResizingBehaviour(survey) {
        var _this = this;
        this.survey = survey;
        this.listener = function (event) { return _this.receiveRequest(event); };
        window.addEventListener("message", this.listener, false);
    }
    EmbedResizingBehaviour.prototype.destroy = function () {
        window.removeEventListener("message", this.listener);
    };
    EmbedResizingBehaviour.prototype.postHeight = function () {
        var _this = this;
        setTimeout(function () { return top.postMessage({
            totalsurvey_insights: {
                uid: _this.survey.uid,
                action: 'resizeHeight',
                value: document.documentElement.getBoundingClientRect().height
            }
        }, '*'); }, 1000);
    };
    EmbedResizingBehaviour.prototype.receiveRequest = function (event) {
        if (event.data.totalsurvey_insights && event.data.totalsurvey_insights.uid === this.survey.uid && event.data.totalsurvey_insights.action === 'resizeHeight') {
            this.postHeight();
        }
    };
    return EmbedResizingBehaviour;
}());
document.querySelectorAll(".totalsurvey-insights-wrapper").forEach(function (wrapperElement) {
    var template = wrapperElement.querySelector("template");
    var host = document.createElement("div");
    host.classList.add("totalsurvey-survey-insights");
    host.attachShadow({ mode: "open" }).append(template.content);
    template.after(host);
    host.shadowRoot.querySelectorAll("survey-style, survey-link, survey-script").forEach(function (el) {
        var style = document.createElement(el.tagName.toLowerCase().replace("survey-", ""));
        style.textContent = el.textContent;
        el.getAttributeNames().forEach(function (name) { return style.setAttribute(name, el.getAttribute(name)); });
        el.after(style);
        el.remove();
    });
    new Vue({
        el: host.shadowRoot.querySelector("#survey-insights"),
        components: {
            "survey-insights": SurveyInsightsComponent,
        },
        mounted: function () {
            host.shadowRoot.instance = this;
        },
    });
    template.remove();
});
//# sourceMappingURL=app.js.map