export default function Loading() {
  return (
    <div className="ajm-page-loading" role="status" aria-live="polite" aria-label="Loading page" aria-busy="true">
      <div className="ajm-page-loading-mark" aria-hidden="true">AJM</div>
      <span>Preparing your next page</span>
      <div className="ajm-page-loading-lines" aria-hidden="true"><i /><i /><i /></div>
      <div className="ajm-page-loading-skeleton" aria-hidden="true">
        <i className="ajm-skeleton" />
        <i className="ajm-skeleton" />
        <i className="ajm-skeleton" />
      </div>
    </div>
  );
}
