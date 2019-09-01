import React, {Component} from 'react';
import Footer from './Common/Footer';
import Header from "./Auth/Login";

class MasterNoLogin extends Component{
    render() {
        return (
            <React.Fragment>
                <Header />
                    Index
                <Footer />
            </React.Fragment>
        );
    }
}

export default MasterNoLogin;
