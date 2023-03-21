/**
 * @package     AesirX
 * @subpackage  BI
 *
 * @copyright   Copyright (C) 2023 AesirX. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

import React from 'react';
import { createRoot } from 'react-dom/client';
import BIApp from './app';
const container = document.getElementById('biapp');
const root = createRoot(container); // createRoot(container!) if you use TypeScript
root.render(<BIApp />);
