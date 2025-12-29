import React from "react";
import {TemporaryEmailBox} from "../../types/types";

interface Props {
  temporaryEmailBox: TemporaryEmailBox | null;
}

const Inbox = ({temporaryEmailBox}: Props) => {
  return (
    <section className="section">
      <div className="container">
        <div className="columns is-centered">
          <div className="column is-8">
            <div className="box p-0" style={{borderRadius: "12px", overflow: "hidden"}}>

              {/* Header */}
              <div className="columns is-mobile m-0 has-background-dark py-3 px-4">
                <div className="column has-text-white has-text-weight-semibold">SENDER</div>
                <div className="column has-text-white has-text-weight-semibold">SUBJECT</div>
                <div className="column has-text-white has-text-weight-semibold has-text-right">VIEW</div>
              </div>

              {/* Empty State */}
              <div className="has-text-centered p-6">
                <span className="icon is-large">
                  <i className="fas fa-sync-alt fa-spin fa-3x has-text-grey-light"></i>
                </span>

                <p className="title is-5 has-text-grey-dark mt-4">Your inbox is empty</p>
                <p className="subtitle is-6 has-text-grey">
                  Waiting for incoming emails
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}

export default Inbox;
