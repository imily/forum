import React, {Component} from 'react';

class Page extends Component {
    constructor(props) {
        super(props);
    }

    render() {
        const list = this.props.list;

        return (
            <ul className="pages">
                {list.map((item, index) =>
                    <li key={index}>
                        <button value={item}
                                onMouseOver={this.props.onMainMouseOver}
                                onClick={this.props.onMainClick}>{item}
                        </button>
                    </li>
                )}
            </ul>
        );
    }
}

export default Page;
