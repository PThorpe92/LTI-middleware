# Security Policy

## Supported Versions

Use this section to tell people about which versions of your project are
currently being supported with security updates.

| Version | Supported          |
| ------- | ------------------ |
| 5.1.x   | :white_check_mark: |
| 5.0.x   | :x:                |
| 4.0.x   | :white_check_mark: |
| < 4.0   | :x:                |

## Reporting a Vulnerability

Use this section to tell people how to report a vulnerability.

Tell them where to go, how often they can expect to get an update on a
reported vulnerability, what to expect if the vulnerability is accepted or
declined, etc.




Security Release Process
Unlocked labs is a community devoted to creating open-source technology to create a better justice system. The community has adopted this security disclosure and response policy to ensure we responsibly handle critical issues.

Supported Versions
The UnlockEd project maintains release branches for the three most recent minor releases. Applicable fixes, including security fixes, may be backported to those three release branches, depending on severity and feasibility. Please refer to RELEASES.md for details.

Reporting a Vulnerability - Private Disclosure Process
Security is of the highest importance and all security vulnerabilities or suspected security vulnerabilities should be reported to Unlocked Labs privately, to minimize attacks against current users of Harbor before they are fixed. Vulnerabilities will be investigated and patched on the next patch (or minor) release as soon as possible. This information could be kept entirely internal to the project.

If you know of a publicly disclosed security vulnerability for UnlockEd, please IMMEDIATELY contact founders@unlockedlabs.org to inform the Unlocked Labs Security Team.

IMPORTANT: Do not file public issues on GitHub for security vulnerabilities

To report a vulnerability or a security-related issue, please email the private address founders@unlockedlabs.org with the details of the vulnerability. The email will be fielded by the Unlocked Labs Security Team, which is made up of Unlocked Labs maintainers who have committer and release permissions. Emails will be addressed within 7 business days, including a detailed plan to investigate the issue and any potential workarounds to perform in the meantime. Do not report non-security-impacting bugs through this channel. Use GitHub issues instead.

Proposed Email Content
Provide a descriptive subject line and in the body of the email include the following information:

Basic identity information, such as your name and your affiliation or company.
Detailed steps to reproduce the vulnerability (POC scripts, screenshots, and compressed packet captures are all helpful to us).
Description of the effects of the vulnerability on Harbor and the related hardware and software configurations, so that the Unlocked Labs Security Team can reproduce it.
How the vulnerability affects UnlockEd usage and an estimation of the attack surface, if there is one.
List other projects or dependencies that were used in conjunction with UnlockEd to produce the vulnerability.
When to report a vulnerability
When you think UnlockEd has a potential security vulnerability.
When you suspect a potential vulnerability, but you are unsure that it impacts Harbor.
When you know of or suspect a potential vulnerability on another project that is used by UnlockEd. For example UnlockEd has a dependency on Docker, PGSql, Redis, Notary, Trivy, etc.
Patch, Release, and Disclosure
The Unlocked Labs Security Team will respond to vulnerability reports as follows:

The Security Team will investigate the vulnerability and determine its effects and criticality.
If the issue is not deemed to be a vulnerability, the Security Team will follow up with a detailed reason for rejection.
The Security Team will initiate a conversation with the reporter within 3 business days.
If a vulnerability is acknowledged and the timeline for a fix is determined, the Security Team will work on a plan to communicate with the appropriate community, including identifying mitigating steps that affected users can take to protect themselves until the fix is rolled out.
The Security Team will work on fixing the vulnerability and perform internal testing before preparing to roll out the fix.
A public disclosure date is negotiated by the Unlocked Labs Security Team, the bug submitter, and the distributors list. We prefer to fully disclose the bug as soon as possible once a user mitigation or patch is available. It is reasonable to delay disclosure when the bug or the fix is not yet fully understood, the solution is not well-tested, or for distributor coordination. The timeframe for disclosure is from immediate (especially if it’s already publicly known) to a few weeks. For a critical vulnerability with a straightforward mitigation, we expect report date to public disclosure date to be on the order of 14 business days. Unlocked Labs Security Team holds the final say when setting a public disclosure date.
Once the fix is confirmed, the Security Team will patch the vulnerability in the next patch or minor release, and backport a patch release into all earlier supported releases. Upon release of the patched version of UnlockEd, we will follow the Public Disclosure Process.

Public Disclosure Process
The Security Team publishes a public advisory to the UnlockEd community via GitHub. In most cases, additional communication via Slack, Twitter, CNCF lists, blog and other channels will assist in educating UnlockEd users and rolling out the patched release to affected users.

The Security Team will also publish any mitigating steps users can take until the fix can be applied to their Harbor instances. UnlockEd distributors will handle creating and publishing their own security advisories.

Mailing lists
We do not currently have a security listsrv but will be creating one in the near future. Once we do, the listsrv will be made known here and you are encouraged to utilize it.ormation on security patch releases. See below for information on how Harbor distributors or vendors can apply to join this list.

Confidentiality, integrity and availability
We consider vulnerabilities leading to the compromise of data confidentiality, elevation of privilege, or integrity to be our highest priority concerns. Availability, in particular in areas relating to DoS and resource exhaustion, is also a serious security concern. The Unlocked Labs Security Team takes all vulnerabilities, potential vulnerabilities, and suspected vulnerabilities seriously and will investigate them in an urgent and expeditious manner.

Note that we do not currently consider the default settings for UnlockEd to be secure-by-default. It is necessary for operators to explicitly configure settings, role based access control, and other resource related features in UnlockEd to provide a hardened UnlockEd environment. We will not act on any security disclosure that relates to a lack of safe defaults. Over time, we will work towards improved safe-by-default configuration, taking into account backwards compatibility.
