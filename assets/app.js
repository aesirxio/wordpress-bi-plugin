import React, { lazy, Suspense } from 'react';
import 'aesirx-bi-app/dist/index.css';
import 'aesirx-bi-app/dist/app.css';
import './app.scss';

const BiIntegration = lazy(() => import('./bi.js'));

const BIApp = () => {
  return (
    <Suspense fallback={<div>Loading...</div>}>
      <BiIntegration />
    </Suspense>
  );
};

export default BIApp;
