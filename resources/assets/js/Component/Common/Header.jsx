import React, {Component} from 'react';
import Menu from './Menu';
import Banner from './Banner';

class Header extends Component{
    render() {
        return (
            <div className="header">
                <Menu />
                <Banner />
            </div>
        );
    }
}

export default Header;
