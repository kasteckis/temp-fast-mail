import React, {useEffect, useState} from "react";
import {ReceivedEmailResponseListDto, TemporaryEmailBox} from "../../types/types";
import axios from "axios";

interface Props {
  temporaryEmailBox: TemporaryEmailBox | null;
}

const Inbox = ({temporaryEmailBox}: Props) => {
  const [receivedEmails, setReceivedEmails] = useState<ReceivedEmailResponseListDto[]>([]);

  useEffect(() => {
    if (temporaryEmailBox === null) {
      return;
    }

    axios.get('/api/email-box/' + temporaryEmailBox.uuid + '/emails')
      .then(r => {
        const emails = r.data as ReceivedEmailResponseListDto[];

        // setReceivedEmails(emails);

        setReceivedEmails([
          {
            uuid: "b3863e71-4121-4d86-8693-a9d9315ab12f",
            real_from: "qweqwe@qwe.com",
            real_to: "qweqwe@qwe.com",
            from_name: "Valentinas",
            subject: "CONFIRMATION CODE- BLA BLA BLA",
            received_at: new Date(),
          },
        ]);
      });
  }, [temporaryEmailBox])

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

              {receivedEmails.length === 0 && (
                <div className="has-text-centered p-6">
                <span className="icon is-large">
                  <i className="fas fa-sync-alt fa-spin fa-3x has-text-grey-light"></i>
                </span>
                  <p className="title is-5 has-text-grey-dark mt-4">Your inbox is empty</p>
                  <p className="subtitle is-6 has-text-grey">
                    Waiting for incoming emails. Will refresh automatically when new emails arrive.
                  </p>
                </div>
              )}

              {receivedEmails.map(email => {
                return (
                  <div
                    key={email.uuid}
                    className="columns is-mobile m-0 py-3 px-4 is-vcentered is-clickable"
                    style={{ borderBottom: "1px solid #eee" }}
                  >

                    {/* Left block: Sender + email + subject (mobile stacked, desktop columns) */}
                    <div className="column">
                      <p className="has-text-weight-semibold">{email.from_name}</p>

                      {/* email */}
                      <p className="is-size-7 has-text-grey">{email.real_from}</p>

                      {/* Subject visible on mobile only (since tablet has its own column) */}
                      <p className="is-size-7 has-text-grey is-hidden-tablet">
                        {email.subject}
                      </p>
                    </div>

                    {/* Subject column (tablet and desktop only) */}
                    <div className="column is-hidden-mobile">
                      <p className="is-size-6">{email.subject}</p>
                    </div>

                    {/* View icon */}
                    <div className="column is-narrow has-text-right">
                      <span className="icon has-text-grey-dark">
                        <i className="fas fa-envelope-open-text"></i>
                      </span>
                    </div>
                  </div>
                );
              })}
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}

export default Inbox;
