"use strict";
(function (blocks, element) {
    var el = element.createElement;

    var blockStyle = {
        backgroundColor: '#900',
        color: '#fff',
        padding: '20px',
    };

    blocks.registerBlockType('totalsurvey/survey', {
        title: 'Survey',
        icon: 'feedback',
        category: 'widgets',
        attributes: {
            surveyId: {
                type: 'number'
            }
        },
        edit: function (props) {
            const {attributes: {surveyId}, setAttributes} = props;

            var options = TotalSurveyData.surveys.map(survey => {
                return el('option', {
                    value: survey.id,
                    label: survey.name,
                    selected: surveyId == survey.id
                });
            });

            options.unshift(el('option', {
                value: '',
                label: 'Select a survey'
            }));

            const setSurveyId = (surveyId) => setAttributes({surveyId: Number(surveyId)});

            return el(
                'div',
                {},
                [
                    el('div', {
                        style: {
                            backgroundColor: '#0288D1',
                            color: '#ffffff',
                            padding: '20px'
                        }
                    }, 'TotalSurvey'),
                    el(
                        'div',
                        {
                            style: {
                                padding: '20px',
                                backgroundColor: '#fafafa'
                            }
                        },
                        el(
                            'select',
                            {
                                style: {
                                    width: '100%',
                                    maxWidth: 'none',
                                },
                                onChange: (event) => {
                                    setSurveyId(event.target.value);
                                }
                            },
                            options
                        )
                    )
                ]
            )
        },
        save: function () {
            return el(wp.element.RawHTML, null, '');
        },
    });
}(
    window.wp.blocks,
    window.wp.element
));
