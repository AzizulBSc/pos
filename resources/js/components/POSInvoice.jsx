import React from "react";

const Invoice = ({ invoiceData }) => {
    const {
        siteLogo,
        siteName,
        currentDate,
        siteDetails,
        noteToCustomer,
        sale,
        currencySymbol,
    } = invoiceData;
    console.log("dataInvoice:", invoiceData);
    return (
        <div className="card">
            <div className="card-body">
                <section className="invoice">
                    {/* Title row */}
                    <div className="row mb-4">
                        <div className="col-4">
                            <h2 className="page-header">
                                <img
                                    src={siteLogo}
                                    height="40"
                                    width="40"
                                    alt="Logo"
                                    className="brand-image img-circle elevation-3"
                                    style={{ opacity: 0.8 }}
                                />
                            </h2>
                        </div>
                        <div className="col-4">
                            <h4 className="page-header">Invoice</h4>
                        </div>
                        <div className="col-4">
                            <small className="float-right text-small">
                                Date: {currentDate}
                            </small>
                        </div>
                    </div>

                    {/* Info row */}
                    <div className="row invoice-info">
                        <div className="col-sm-5 invoice-col">
                            <strong>
                                Name: {sale?.customer.name || "N/A"}
                            </strong>
                            <address>
                                Address: {sale?.customer.address || "N/A"}
                                <br />
                                Phone: {sale?.customer.phone || "N/A"}
                            </address>
                        </div>
                        <div className="col-sm-4 invoice-col">
                            From
                            <address>
                                <strong>Name: {siteName}</strong>
                                <div>Address: {siteDetails}</div>
                            </address>
                        </div>
                        <div className="col-sm-3 invoice-col">
                            <strong>Info</strong>
                            <br />
                            Sale ID #{sale.id}
                            <br />
                            Sale Date: {sale.created_at}
                        </div>
                    </div>

                    {/* Table row */}
                    <div className="row">
                        <div className="col-12 table-responsive">
                            <table className="table table-striped">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Price ({currencySymbol})</th>
                                        <th>Subtotal ({currencySymbol})</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {sale.products.map((item, index) => (
                                        <tr key={index}>
                                            <td>{index + 1}</td>
                                            <td>{item.product.name}</td>
                                            <td>
                                                {item.quantity}{" "}
                                                {item.product.unit}
                                            </td>
                                            <td>
                                                {item.discounted_price}
                                                {item.price >
                                                    item.discounted_price && (
                                                    <>
                                                        <br />
                                                        <del>{item.price}</del>
                                                    </>
                                                )}
                                            </td>
                                            <td>{item.total}</td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {/* Totals */}
                    <div className="row">
                        <div className="col-6">
                            <p
                                className="text-muted well well-sm shadow-none"
                                style={{ marginTop: 10 }}
                            >
                                {noteToCustomer}
                            </p>
                        </div>
                        <div className="col-6">
                            <table className="table">
                                <tbody>
                                    <tr>
                                        <th style={{ width: "50%" }}>
                                            Subtotal:
                                        </th>
                                        <td className="text-right">
                                            {currencySymbol}{" "}
                                            {sale.sub_total.toFixed(2)}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Discount:</th>
                                        <td className="text-right">
                                            {currencySymbol}{" "}
                                            {sale.discount.toFixed(2)}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Total:</th>
                                        <td className="text-right">
                                            {currencySymbol}{" "}
                                            {sale.total.toFixed(2)}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Paid:</th>
                                        <td className="text-right">
                                            {currencySymbol}{" "}
                                            {sale.paid.toFixed(2)}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Due:</th>
                                        <td className="text-right">
                                            {currencySymbol}{" "}
                                            {sale.due.toFixed(2)}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {/* Print Button */}
                    <div className="row no-print">
                        <div className="col-12">
                            <button
                                type="button"
                                onClick={() => window.print()}
                                className="btn btn-success float-right"
                            >
                                <i className="fas fa-print"></i> Print
                            </button>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    );
};

export default Invoice;
