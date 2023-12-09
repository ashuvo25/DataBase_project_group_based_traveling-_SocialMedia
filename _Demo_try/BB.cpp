 /*******************বিসমিল্লাহির রাহমানির রাহিম **********************/
 /*__________________ MD ASADUZZAMAN SHUVO ______________________ */

#include<bits/stdc++.h>
using namespace std;

#define ll long long
const int INF = 1e9+10;
const int N = 1e5+10;

int main() {
    int n;
    cin >> n;
    vector<string> strings(n);
    for (int i = 0; i < n; ++i) {
        cin >> strings[i];
    }
    int total_length = 0;
    for (int i = 0; i < n; ++i) {
        for (int j = 0; j < n; ++j) {
            string a = strings[i];
            string b = strings[j];
            string m = a+b;
            if (a.empty()) total_length += b.length();
            else if (b.empty())total_length += a.length();
            else if (a.back() == b.front()){
                string a_sub = a.substr(0,a.length() - 1); 
                string b_sub = b.substr(0, b.length());
                // cout<< a.length() << " " << b.length();
                total_length += -a_sub.length()+ b_sub.length() ;  
            }
            else total_length += m.length();
        }
    }
    cout << total_length << endl;
    return 0;
}