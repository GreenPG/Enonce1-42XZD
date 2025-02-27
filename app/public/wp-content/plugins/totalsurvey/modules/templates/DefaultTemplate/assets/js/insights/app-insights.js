"use strict";
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
                                                text += " " + percent + " (" + item + " out of " + that.question.total + ")";
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
                                    return percent + " (" + label + " out of " + that.question.total + ")";
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
                                    return " " + context.dataset.label + " :";
                                },
                                afterLabel: function (context) {
                                    var data = context.dataset.data;
                                    var label = context.formattedValue || String(data[context.dataIndex]) || '';
                                    var labelDataset = context.dataset.label;
                                    return label + "% (" + that.question.values.data[labelDataset][context.dataIndex] + " out of " + that.question.values.criteria[context.label].total + ")";
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
                                    var data = dataset.data[index].toFixed(2) + "%";
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
            new Chart(this.$refs["chart-" + this.section.uid + "-" + this.index], chartConfig_1);
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
                return result.toFixed(2) + "%";
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
//# sourceMappingURL=app-insights.js.map