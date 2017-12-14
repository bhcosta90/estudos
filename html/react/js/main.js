var Title = function (props) {
    return React.createElement(
        'div',
        { className: 'container' },
        React.createElement(
            'div',
            { className: 'row' },
            React.createElement(
                'h1',
                null,
                props.title
            )
        )
    );
};

var Nav = function (props) {
    return React.createElement(
        'nav',
        { className: 'navbar navbar-default' },
        React.createElement(
            'div',
            { className: 'container' },
            React.createElement(
                'div',
                { className: 'navbar-header' },
                React.createElement(
                    'a',
                    { href: props.linkUrl, className: 'navbar-brand' },
                    props.title
                )
            )
        )
    );
};

ReactDOM.render(React.createElement(Nav, { title: 'React', linkUrl: 'index.html' }), document.getElementById('nav'));

ReactDOM.render(React.createElement(Title, { title: 'Hello World' }), document.getElementById('title'));