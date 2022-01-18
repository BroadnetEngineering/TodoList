class SplashPage extends React.Component {

    constructor (props) {
        super(props);
        this.state = { data : {} };
        this.navigate = this.props.navigate;
        this.mounted = false;
    }

    /* 
     * When the component is mounted, call the updateSplashPage function
     * Although it's not really necessary for the splash page content to 
     * stay updated after the component has mounted, this is an example
     * of how you can use setInterval to fetch data from the API at specific
     * intervals and update the state of the component
     */
    componentDidMount () {
        this.updateSplashPage();
        setInterval(function () {
            this.updateSplashPage();
        }.bind(this),10000);
    }

    /*
     * This sends the json '{"fetch":"splashPage"}' in the body
     * of a POST request to /api/index/splash_page. This will create an 
     * instance of IndexController and call it's function SplashPageAction. 
     * SplashPageAction returns the "splashPage" array from config.json.
     * It then updates the state using the data returned from the api,
     * which automatically updates the splash page
     */
    async updateSplashPage () {
        try {
            const requestOptions = {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ fetch : 'splashPage' })
            };
            const res = await fetch("/api/index/splash_page", requestOptions);
            const data = await res.json();
            this.setState({ data : data });
            if (!this.mounted) {
                $(".component-container").fadeIn(300,function () {
                    this.mounted = true;
                });
            }
        } catch (e) {
            console.error(e);
        }
    }

    render () {
        return (
            <div className="component-container">
                <div className="splash-container">
                    <div className="splash">
                        <h1 className="splash-head">Todo List</h1>
                        <div className="splash-subhead">
                            Add an item to your list
                            <input className="numbers-input" type="text" id="numbers" />
                            <p>
                                <a className="pure-button pure-button-primary">
                                    Submit
                                </a>
                            </p>
                            <div className="markdown-body" style={{textAlign: "left"}}>
                                <p style={{padding: "10px", marginBottom: "0"}}>Todo List:</p>
                                <pre>
                                    <code>
                                        &nbsp;
                                    </code>
                                </pre>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
        )
    }
}