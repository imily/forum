import React, {Component} from 'react';

class Footer extends Component{
    render() {
        return (
            <div>
                <div className="footer">
                    <div className="container">
                        <span className="author" itemProp="author">Information takes from Person of Interest (TV series) - Wikipedia</span>
                        <span className="copyright" itemProp="copyrightHolder">© Copyright 2018. Person of Interest </span>
                        <div className="links">
                            <a href="" className="fb"> </a>
                            <a href="" className="twitter"> </a>
                        </div>
                    </div>
                </div>
                <a href ="#" className = "gototop" > </a>
            </div>
        );
    }
}

export default Footer;
