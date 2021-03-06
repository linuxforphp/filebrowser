.. _TranslationsAnchor:

============
Translations
============

.. index:: Translations

The language setting is configured by adjusting the ``language`` variable in the
``configuration.php`` file.

Available languages:

-  ``english`` (default)
-  ``spanish``
-  ``german``
-  ``indonesian``
-  ``turkish``
-  ``lithuanian``
-  ``portuguese``
-  ``dutch``
-  ``chinese`` (simplified)
-  ``bulgarian``
-  ``serbian``
-  ``french``
-  ``slovak``
-  ``polish``
-  ``italian``
-  ``korean``
-  ``czech``
-  ``galician``
-  ``russian``
-  ``hungarian``
-  ``swedish``
-  ``japanese``

Please help us in translating the FileBrowser application to your language,
by submitting a Pull Request on GitHub.

----------------
How to Translate
----------------

.. index:: Translate FileBrowser

First, you must setup the project like described in the :ref:`development`
section. The default language file is located under
``frontend/translations/english.js``. You can add more languages in the
same folder. Once your language file is in place, it needs to be added
to ``frontend/mixins/shared.js`` file. After this, recompile everything with
``npm run build``, and you will then be able to use it by changing the
``language`` variable in the ``configuration.php`` file.

You should only translate the value on the right. For example:

::

    'Close': 'Schliessen',

Here is the default language file:

::

    const data = {
     'Selected': 'Selected: {0} of {1}',
     'Uploading files': 'Uploading {0}% of {1}',
     'File size error': '{0} is too large, please upload files less than {1}',
     'Upload failed': '{0} failed to upload',
     'Per page': '{0} Per Page',
     'Folder': 'Folder',
     'Login failed, please try again': 'Login failed, please try again',
     'Already logged in': 'Already logged in.',
     'Please enter username and password': 'Please enter username and password.',
     'Not Found': 'Not Found',
     'Not Allowed': 'Not Allowed',
     'Please log in': 'Please log in',
     'Unknown error': 'Unknown error',
     'Add files': 'Add files',
     'New': 'New',
     'New name': 'New name',
     'Username': 'Username',
     'Password': 'Password',
     'Login': 'Log in',
     'Logout': 'Log out',
     'Profile': 'Profile',
     'No pagination': 'No pagination',
     'Time': 'Time',
     'Name': 'Name',
     'Size': 'Size',
     'Home': 'Home',
     'Copy': 'Copy',
     'Move': 'Move',
     'Rename': 'Rename',
     'Required': 'Please fill out this field',
     'Zip': 'Zip',
     'Batch Download': 'Batch Download',
     'Unzip': 'Unzip',
     'Delete': 'Delete',
     'Download': 'Download',
     'Copy link': 'Copy link',
     'Done': 'Done',
     'File': 'File',
     'Drop files to upload': 'Drop files to upload',
     'Close': 'Close',
     'Select Folder': 'Select Folder',
     'Users': 'Users',
     'Files': 'Files',
     'Role': 'Role',
     'Cancel': 'Cancel',
     'Paused': 'Paused',
     'Confirm': 'Confirm',
     'Create': 'Create',
     'User': 'User',
     'Admin': 'Admin',
     'Save': 'Save',
     'Read': 'Read',
     'Write': 'Write',
     'Upload': 'Upload',
     'Permissions': 'Permissions',
     'Homedir': 'Home Folder',
     'Leave blank for no change': 'Leave blank for no change',
     'Are you sure you want to do this?': 'Are you sure you want to do this?',
     'Are you sure you want to allow access to everyone?': 'Are you sure you want to allow access to everyone?',
     'Are you sure you want to stop all uploads?': 'Are you sure you want to stop all uploads?',
     'Something went wrong': 'Something went wrong',
     'Invalid directory': 'Invalid directory',
     'This field is required': 'This field is required',
     'Username already taken': 'Username already taken',
     'User not found': 'User not found',
     'Old password': 'Old password',
     'New password': 'New password',
     'Wrong password': 'Wrong password',
     'Updated': 'Updated',
     'Deleted': 'Deleted',
     'Your file is ready': 'Your file is ready',
     'View': 'View',
    }

    export default data
