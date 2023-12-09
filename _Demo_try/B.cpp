 /*******************বিসমিল্লাহির রাহমানির রাহিম **********************/
 /*__________________ MD ASADUZZAMAN SHUVO ______________________ */

#include<bits/stdc++.h>
using namespace std;

#define ll long long
const int INF = 1e9+10;
const int N = 1e5+10;



int main() {
    int t;
    cin >> t;

    while (t--) {
        int n;
        cin >> n;
        vector<int> a(n);
        for (int i = 0; i < n; i++) {
            cin >> a[i];
        }

        sort(a.begin(), a.end());
        int an_1 = a[n - 1];
        int an_plus_1 = an_1 + 1;
        int x = an_plus_1 - a[n - 2];
        ll operations = 0;
        for (int i = 0; i < n - 1; i++) {
            operations += max(0, an_plus_1 - a[i]);
        }
        cout << operations << endl;
    }

    return 0;
}
