var EmbedResizingBehaviour = /** @class */ (function () {
    function EmbedResizingBehaviour(survey) {
        var _this = this;
        this.survey = survey;
        console.log(survey);
        this.listener = function (event) { return _this.receiveRequest(event); };
        window.addEventListener("message", this.listener, false);
    }
    EmbedResizingBehaviour.prototype.destroy = function () {
        window.removeEventListener("message", this.listener);
    };
    EmbedResizingBehaviour.prototype.postHeight = function () {
        var frame = document.getElementById("survey-insights-" + this.survey.uid);
        frame.contentWindow.postMessage({
            totalsurvey_insights: {
                uid: this.survey.uid,
                action: 'resizeHeight',
                value: document.documentElement.getBoundingClientRect().height
            }
        }, '*');
    };
    EmbedResizingBehaviour.prototype.receiveRequest = function (event) {
        if (event.data.totalsurvey_insights && event.data.totalsurvey_insights.uid === this.survey.uid && event.data.totalsurvey_insights.action === 'requestHeight') {
            this.postHeight();
        }
    };
    return EmbedResizingBehaviour;
}());
