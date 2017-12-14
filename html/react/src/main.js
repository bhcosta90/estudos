var Title = function(props){
    return (
        <div className='container'>
            <div className='row'>
                <h1>{props.title}</h1>
            </div>
        </div>
    );
}

var Nav = function(props){
    return (
        <nav className='navbar navbar-default'>
            <div className='container'>
                <div className='navbar-header'>
                    <a href={props.linkUrl} className="navbar-brand">{props.title}</a>
                </div>
            </div>
        </nav>
    );
}

ReactDOM.render(
  <Nav title="React" linkUrl='index.html' />,
  document.getElementById('nav')
);

ReactDOM.render(
  <Title title="Hello World" />,
  document.getElementById('title')
);
